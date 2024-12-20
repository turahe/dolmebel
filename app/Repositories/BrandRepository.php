<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\BrandRepositoryInterface;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function __construct(Brand $model)
    {
        parent::__construct($model);
        $this->model = $model;

    }

    /**
     * @throws \Exception
     */
    public function createBrand(array $data): Brand
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function updateBrand(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function deleteBrand(): bool
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
    public function trashBrand(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getBrands(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * @throws \Exception
     */
    public function getBrand(string $id): Brand
    {
        try {
            return $this->model->where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function getBrandsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()->orderBy($order, $sort);
    }
}
