<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface PageRepositoryInterface extends BaseRepositoryInterface
{
    public function createPage(array $data): Page;

    public function updatePage(array $data): bool;

    public function deletePage(): bool;

    public function getPagesBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getPages(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getPageBySlug(string $slug): Page;

    public function massTrashPages(array $ids): bool;

    public function massRestorePages(array $ids): bool;

    public function massDestroyPages(array $ids): bool;

    public function emptyTrashPages(): bool;

    public function onlyTrashPages(): Collection;

    public function restore(): bool;
}
