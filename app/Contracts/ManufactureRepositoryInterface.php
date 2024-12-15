<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Manufacture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface ManufactureRepositoryInterface extends BaseRepositoryInterface
{
    public function createManufacture(array $data): Manufacture;

    public function updateManufacture(array $data): bool;

    public function deleteManufacture(): bool;

    public function trashManufacture(): bool;

    public function getManufactures(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getManufacture(string $id): Manufacture;

    public function getManufacturesBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;
}
