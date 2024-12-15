<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;
use Turahe\Post\Models\Post;

interface CouponRepositoryInterface extends BaseRepositoryInterface
{
    public function create(array $data): Post;

    public function update(array $data): bool;

    public function delete(): bool;

    public function getCoupons(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getCouponsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getCoupon(string $slug): Post;
}
