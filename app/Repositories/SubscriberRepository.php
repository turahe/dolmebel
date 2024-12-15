<?php

namespace App\Repositories;

use App\Contracts\SubscriberRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;
use Turahe\Subscription\Models\PlanSubscription;

class SubscriberRepository extends BaseRepository implements SubscriberRepositoryInterface
{
    public function __construct(PlanSubscription $model)
    {
        parent::__construct($model);
    }

    public function createSubscriber(array $data): PlanSubscription
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function updateSubscriber(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function deleteSubscriber(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getSubscribers(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getSubscribersBuilder($order, $sort)->get($except);
    }

    public function getSubscriber(string $id): PlanSubscription
    {
        try {
            return $this->model->findOrFail($id);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getSubscribersBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->newQuery()->orderBy($order, $sort);
    }
}
