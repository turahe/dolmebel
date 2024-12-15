<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\BankRepositoryInterface;
use App\Models\Bank;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class BankRepository extends BaseRepository implements BankRepositoryInterface
{
    public function __construct(Bank $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @throws Exception
     */
    public function createBank(array $data): Bank
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
    public function updateBank(array $data): bool
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
    public function deleteBank(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getBanksBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()->orderBy($order, $sort);
    }

    public function getBanks(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getBanksBuilder($order, $sort)->get()->except($except);
    }

    /**
     * @throws Exception
     */
    public function getBank(string|int $account): Bank
    {
        try {
            return $this->model->where('account_number', $account)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function trash(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
