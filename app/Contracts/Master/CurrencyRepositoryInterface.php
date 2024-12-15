<?php

declare(strict_types=1);

namespace App\Contracts\Master;

use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;
use Turahe\Master\Models\Currency;

interface CurrencyRepositoryInterface extends BaseRepositoryInterface
{
    public function createCurrency(array $data): Currency;

    public function updateCurrency(array $data): bool;

    public function deleteCurrency(): bool;

    public function getCurrencies(): Collection;

    public function getCurrencyCode(string $code): Currency;

    public function trash(): bool;
}
