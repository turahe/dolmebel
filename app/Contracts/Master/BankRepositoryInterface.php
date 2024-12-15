<?php

declare(strict_types=1);

namespace App\Contracts\Master;

use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;
use Turahe\Master\Models\Bank;

interface BankRepositoryInterface extends BaseRepositoryInterface
{
    public function createBank(array $data): Bank;

    public function updateBank(array $data): bool;

    public function deleteBank(): bool;

    public function getBanks(): Collection;

    public function getBank(string $code): Bank;

    public function trash(): bool;
}
