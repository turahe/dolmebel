<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;
use Turahe\Subscription\Models\PlanSubscription;

interface SubscriberRepositoryInterface extends BaseRepositoryInterface
{
    public function createSubscriber(array $data): PlanSubscription;

    public function updateSubscriber(array $data): bool;

    public function deleteSubscriber(): bool;

    public function getSubscribers(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getSubscriber(string $id): PlanSubscription;

    public function getSubscribersBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;
}
