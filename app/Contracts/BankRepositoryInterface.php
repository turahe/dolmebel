<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface BankRepositoryInterface extends BaseRepositoryInterface
{
    public function createBank(array $data): Bank;

    public function updateBank(array $data): bool;

    public function deleteBank(): bool;

    public function getBanksBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getBanks(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getBank(string|int $account): Bank;

    public function trash(): bool;
}
