<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\TaxRepositoryInterface;
use App\Models\Tax;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class TaxRepository extends BaseRepository implements TaxRepositoryInterface
{
    public function __construct(Tax $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @throws Exception
     */
    public function createTax(array $data): Tax
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function updateTax(array $data): bool
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
    public function deleteTax(): bool
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
    public function getTaxes(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * @throws Exception
     */
    public function getIdTax(string $id): Tax
    {
        try {
            return $this->model->where('id', $id)->first();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
