<?php

declare(strict_types=1);

namespace App\Contracts\Master;

use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;
use Turahe\Master\Models\Language;

interface LanguageRepositoryInterface extends BaseRepositoryInterface
{
    public function createLanguage(array $data): Language;

    public function updateLanguage(array $data): bool;

    public function deleteLanguage(): bool;

    public function getLanguages(): Collection;

    public function getLanguageCode(string $code): Language;

    public function trash(): bool;
}
