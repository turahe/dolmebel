<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Tax;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface TaxRepositoryInterface extends BaseRepositoryInterface
{
    public function createTax(array $data): Tax;

    public function updateTax(array $data): bool;

    public function deleteTax(): bool;

    public function getTaxes(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getIdTax(string $id): Tax;
}
