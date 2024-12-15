<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Location;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface LocationRepositoryInterface extends BaseRepositoryInterface
{
    public function getLocations(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getLocation(string $id): Location;

    public function getLocationBySlug(string $slug): Location;

    public function createLocation(array $attributes): Location;

    public function updateLocation(array $attributes): bool;

    public function deleteLocation(): bool;
}
