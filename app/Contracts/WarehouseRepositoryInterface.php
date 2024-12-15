<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface WarehouseRepositoryInterface extends BaseRepositoryInterface
{
    public function createWarehouse(array $data): Warehouse;

    public function updateWarehouse(array $data): bool;

    public function deleteWarehouse(): bool;

    public function getWarehousesBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getWarehouses(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getIdWarehouse(string $id): Warehouse;
}
