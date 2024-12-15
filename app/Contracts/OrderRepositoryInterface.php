<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrder(array $data): Order;

    public function updateOrder(array $data): bool;

    public function deleteOrder(): bool;

    public function getOrders(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getOrdersBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getUserOrders(int $limit = 12): LengthAwarePaginator;

    public function getCodeOrder(string $code): Order;

    public function trashOnly(): Collection;

    public function updateOrderStatus(array $data): bool;
}
