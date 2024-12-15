<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Service;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface ServiceRepositoryInterface extends BaseRepositoryInterface
{
    public function getServices(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getService(string $id): Service;

    public function getServiceBySlug(string $slug): Service;

    public function createService(array $attributes): Service;

    public function updateService(array $attributes): bool;

    public function deleteService(): bool;

    public function trashService(): bool;
}
