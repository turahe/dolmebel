<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\SupplierRepositoryInterface;
use App\Models\Supplier;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Enums\OrganizationType;
use Turahe\Core\Repositories\BaseRepository;

class SupplierRepository extends BaseRepository implements SupplierRepositoryInterface
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
        $this->model = $model;

    }

    public function getSuppliersBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()->orderBy($order, $sort);
    }

    /**
     * @return \Kalnoy\Nestedset\Collection
     */
    public function getSuppliers(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getSuppliersBuilder($order, $sort)->get()->except($except);
    }

    /**
     * @throws Exception
     */
    public function getSupplier(string $id): Supplier
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function getSupplierBySlug(string $slug): Supplier
    {
        try {
            return $this->model->where('slug', $slug)->first();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function createSupplier(array $attributes): Supplier
    {
        $attributes['type'] = OrganizationType::Supplier;
        try {
            return $this->model->create($attributes);
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function updateSupplier(array $attributes): bool
    {
        try {
            return $this->model->update($attributes);
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function deleteSupplier(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function trashSupplier(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function massTrash(array $ids)
    {
        try {
            return $this->model->whereIn('id', $ids)->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function massDestroy(array $ids)
    {
        try {
            return $this->model->whereIn('id', $ids)->forceDelete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
