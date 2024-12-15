<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface ShopRepositoryInterface extends BaseRepositoryInterface
{
    public function createShop(array $data): Shop;

    public function updateShop(array $data): bool;

    public function deleteShop(): bool;

    public function getShopsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getShops(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getIdShop(string $id): Shop;

    public function getShopBySlug(string $slug): Shop;

    public function getShopByCode(string $code): Shop;

    public function emptyTrash(): bool;

    public function massTrash(array $ids): bool;

    public function massDestroy(array $ids): bool;

    public function trashShop(): bool;
}
