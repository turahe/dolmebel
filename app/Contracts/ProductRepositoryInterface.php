<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getProductsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getProducts(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getProduct(string $id): Product;

    public function getProductBySlug(string $slug): Product;

    public function createProduct(array $attributes): Product;

    public function updateProduct(array $attributes): bool;

    public function deleteProduct(): bool;
}
