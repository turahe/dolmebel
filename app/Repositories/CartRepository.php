<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\CartRepositoryInterface;
use App\Models\Cart;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;
use Turahe\Ledger\Models\Invoice;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    public function __construct(Invoice $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCarts(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->newQuery()
            ->where('user_id', auth()->id())
            ->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * @throws Exception
     */
    public function getCart($id): Cart
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function createCart(array $attributes): Cart
    {
        try {
            return $this->model->create($attributes);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function updateCart(array $attributes): bool
    {
        try {
            return $this->model->update($attributes);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function deleteCart(): bool
    {
        try {
            return $this->model->delete();

        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function massDestroy(array $ids): bool
    {
        // TODO: Implement massDestroy() method.
    }
}
