<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\DisputeRepositoryInterface;
use App\Events\Dispute\DisputeCreated;
use App\Events\Dispute\DisputeUpdated;
use App\Models\Dispute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class DisputeRepository extends BaseRepository implements DisputeRepositoryInterface
{
    public function __construct(Dispute $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @throws \Exception
     */
    public function createDispute(array $data): Dispute
    {
        try {
            $dispute = $this->model->create($data);
            $dispute->addPipeline($data['status']);
            event(new DisputeCreated($dispute));

            return $dispute;
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function updateDispute(array $data): bool
    {
        try {
            event(new DisputeUpdated($this->model));
            $this->model->addPipeline($data['status']);

            return $this->model->update($data);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function deleteDispute(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function trashDispute(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getDisputes(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getDisputesBuilder($order, $sort)->get()->except($except);
    }

    public function getDisputesBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()->orderBy($order, $sort);
    }

    /**
     * @throws \Exception
     */
    public function getIdDispute(string $id): Dispute
    {
        try {
            return $this->model->where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }

    }
}
