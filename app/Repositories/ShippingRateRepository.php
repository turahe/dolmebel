<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ShippingRateRepositoryInterface;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class ShippingRateRepository extends BaseRepository implements ShippingRateRepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function create(array $data): Organization
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function update(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function delete(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getShipping(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    public function getId(string $id): Organization
    {
        try {
            return $this->model->findOrFail($id);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
