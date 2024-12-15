<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\LocationRepositoryInterface;
use App\Models\Location;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class LocationRepository extends BaseRepository implements LocationRepositoryInterface
{
    public function __construct(Location $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getLocations(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->all();
    }

    public function getLocation(string $id): Location
    {
        try {
            return $this->model->find($id);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function getLocationBySlug(string $slug): Location
    {
        try {
            return $this->model->where('slug', $slug)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @throws Exception
     */
    public function createLocation(array $attributes): Location
    {
        try {
            return $this->model->create($attributes);
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function updateLocation(array $attributes): bool
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
    public function deleteLocation(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @return bool|null
     *
     * @throws Exception
     */
    public function trashLocation()
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
