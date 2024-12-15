<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Media;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface MediaRepositoryInterface extends BaseRepositoryInterface
{
    public function getMedias(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getMedia(string $id): Media;

    public function getMediaByName(string $name): Media;

    public function getMediaBySlug(string $slug): Media;

    public function createMedia(array $attributes): Media;

    public function updateMedia(array $attributes): bool;

    public function deleteMedia(string $id): bool;
}
