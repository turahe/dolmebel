<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Dispute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface DisputeRepositoryInterface extends BaseRepositoryInterface
{
    public function createDispute(array $data): Dispute;

    public function updateDispute(array $data): bool;

    public function deleteDispute(): bool;

    public function trashDispute(): bool;

    public function getDisputes(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getDisputesBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getIdDispute(string $id): Dispute;
}
