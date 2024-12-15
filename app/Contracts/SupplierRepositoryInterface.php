<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface SupplierRepositoryInterface extends BaseRepositoryInterface
{
    public function getSuppliers(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getSuppliersBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getSupplier(string $id): Supplier;

    public function getSupplierBySlug(string $slug): Supplier;

    public function createSupplier(array $attributes): Supplier;

    public function updateSupplier(array $attributes): bool;

    public function deleteSupplier(): bool;

    public function massTrash(array $ids);

    public function massDestroy(array $ids);
}
