<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\WarehouseRepositoryInterface;
use App\Models\Warehouse;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class WarehouseRepository extends BaseRepository implements WarehouseRepositoryInterface
{
    public function __construct(Warehouse $warehouse)
    {
        parent::__construct($warehouse);
        $this->model = $warehouse;

    }

    /**
     * @throws Exception
     */
    public function createWarehouse(array $data): Warehouse
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function deleteWarehouse(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }

    }

    public function trashWarehouse(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }

    }

    /**
     * @throws Exception
     */
    public function massDestroy($ids): bool
    {
        $warehouses = $this->model->withTrashed()->whereIn('id', $ids)->get();

        try {
            foreach ($warehouses as $warehouse) {
                $warehouse->flushAddresses();
                $warehouse->flushImages();
            }

            return $warehouse->forceDelete();
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function emptyTrash(): bool
    {
        $warehouses = $this->model->onlyTrashed()->get();

        try {
            foreach ($warehouses as $warehouse) {
                $warehouse->flushAddresses();
                $warehouse->clearMediaGroup();
            }

            return $warehouse->forceDelete();
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function saveAddress(array $address, $warehouse): void
    {
        $warehouse->addresses()->create($address);
    }

    /**
     * @throws Exception
     */
    public function updateWarehouse(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getWarehousesBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()->orderBy($order, $sort);
    }

    public function getWarehouses(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getWarehousesBuilder($order, $sort)->get()->except($except);
    }

    /**
     * @throws Exception
     */
    public function getIdWarehouse(string $id): Warehouse
    {
        try {
            return $this->model->where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }
}
