<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\Events\Order\OrderCreated;
use App\Events\Order\OrderUpdated;
use App\Models\Order;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Turahe\Core\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @throws Exception
     */
    public function createOrder(array $data): Order
    {
        try {
            $order = $this->model->create(Arr::except($data, 'items'));
            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $model = $order->items()->create($item);
                }
            }
            //                        event(new OrderCreated($order));

            $order->total_amount = $order->total_price;
            $order->total_invoice = $order->total_price;
            $order->total_unpaid = $order->total_price;
            $order->total_payment = $order->total_price;
            $order->minimum_down_payment = calculate_percentage($order->total_price, 20);
            if ($order->shipping_provider_id) {
                $order->shipping_fee = calculate_percentage($order->total_price, 15);
            }
            if ($order->insurance_provider_id) {
                $order->insurance_fee = calculate_percentage($order->total_price, 1);
            }
            $order->save();

            return $order;
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function updateOrder(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function deleteOrder(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function trashOrder(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getOrders(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getOrdersBuilder($order, $sort)->get()->except($except);
    }

    public function getOrdersBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()->orderBy($order, $sort);
    }

    public function getUserOrders(int $limit = 12): LengthAwarePaginator
    {
        return $this->model->newQuery()->where([
            'model_type' => Auth::user()->getMorphClass(),
            'model_id' => Auth::user()->getKey(),
        ])->with(['insurance', 'shipping'])
            ->paginate($limit);
    }

    /**
     * @throws Exception
     */
    public function getCodeOrder(string $code): Order
    {
        try {
            return $this->model->where('code', $code)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function trashOnly(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * @throws Exception
     */
    public function updateOrderStatus(array $data): bool
    {
        try {
            event(new OrderUpdated($this->model, $data['notify_customer']));

            return $this->model->update($data);

        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
