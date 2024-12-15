<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface BrandRepositoryInterface extends BaseRepositoryInterface
{
    public function createBrand(array $data): Brand;

    public function updateBrand(array $data): bool;

    public function deleteBrand(): bool;

    public function getBrands(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getBrand(string $id): Brand;

    public function getBrandsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;
}
