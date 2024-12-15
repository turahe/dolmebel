<?php

declare(strict_types=1);

namespace App\Contracts\Master;

use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;
use Turahe\Master\Models\Country;

interface LocationRepositoryInterface extends BaseRepositoryInterface
{
    public function createCountry(array $data): Country;

    public function updateCountry(array $data): bool;

    public function deleteCountry(): bool;

    public function getCountries(string $type, string $id): Collection;

    public function getCountry(string $id): Country;

    public function trash(): bool;
}
