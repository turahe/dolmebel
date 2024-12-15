<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Inventory;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface InventoryRepositoryInterface extends BaseRepositoryInterface
{
    public function createInventory(array $data): Inventory;

    public function updateInventory(array $data): bool;

    public function deleteInventory(): bool;

    public function getInventories(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getIdInventory(string $id): Inventory;

    public function trashOnly(): Collection;
}
