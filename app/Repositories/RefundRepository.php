<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\RefundRepositoryInterface;
use App\Enums\Status;
use App\Events\Refunds\RefundApproved;
use App\Events\Refunds\RefundDeclined;
use App\Events\Refunds\RefundInitiated;
use App\Models\Refund;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;
use Turahe\Ledger\Models\Voucher;

class RefundRepository extends BaseRepository implements RefundRepositoryInterface
{
    public function __construct(Refund $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getAllRefundsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()
            ->with(['author', 'shop', 'voucher'])
            ->orderBy($order, $sort);
    }

    public function getAllRefunds(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * @throws \Exception
     */
    public function createRefund(array $data): Refund
    {
        try {
            $refund = $this->model->create($data);
            $refund->addPipeline('NEW');
            event(new RefundInitiated($refund, $refund->author));

            return $refund;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function updateRefund(array $data): bool
    {
        try {
            $this->model->addPipeline($data['status']);

            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function open(): Collection
    {
        $query = $this->model->open()->with(['voucher', 'shop']);

        return $query->get();
    }

    /**
     * @return mixed
     */
    public function closed(): Collection
    {
        $query = $this->model->closed()->with(['voucher', 'shop']);

        return $query->get();
    }

    /**
     * @return mixed
     */
    public function statusOf($status): Collection
    {
        $query = $this->model->statusOf($status)->with(['voucher', 'shop']);

        return $query->get();
    }

    /**
     * @throws \Exception
     */
    public function deleteRefund(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

    /**
     * @throws \Exception
     */
    public function trashRefund(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

    /**
     * @throws \Exception
     */
    public function approve(): bool
    {
        try {
            event(new RefundApproved($this->model, $this->model->author));

            return $this->model->update(['status' => Status::Approved]);
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage());
        }

    }

    /**
     * @throws \Exception
     */
    public function decline(): bool
    {
        try {
            event(new RefundDeclined($this->model, $this->model->author));

            return $this->model->update(['status' => Status::Declined]);
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage());
        }

    }

    public function getIdRefund(string $id): Refund
    {
        try {
            return $this->model->where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function findOrder(string $voucher): Voucher
    {
        try {
            return $this->model->where('voucher_id', $voucher)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }
}
