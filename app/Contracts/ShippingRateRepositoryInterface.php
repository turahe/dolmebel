<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Organization;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface ShippingRateRepositoryInterface extends BaseRepositoryInterface
{
    public function create(array $data): Organization;

    public function update(array $data): bool;

    public function delete(): bool;

    public function getShipping(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getId(string $id): Organization;
}
