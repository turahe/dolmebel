<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface BlogRepositoryInterface extends BaseRepositoryInterface
{
    public function createBlog(array $data): Blog;

    public function updateBlog(array $data): bool;

    public function deleteBlog(): bool;

    public function getBlogsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getBlogs(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getBlog(string $slug): Blog;

    public function restoreBlog(): bool;

    public function trashBlog(): bool;

    public function emptyTrash(): bool;
}
