<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Cart;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface CartRepositoryInterface extends BaseRepositoryInterface
{
    public function getCarts(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getCart($id): Cart;

    public function createCart(array $attributes): Cart;

    public function updateCart(array $attributes): bool;

    public function deleteCart(): bool;

    public function massDestroy(array $ids): bool;
}
