<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface SlideRepositoryInterface extends BaseRepositoryInterface
{
    public function getSlides(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getSlidesBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getSlide(string $id): Slide;

    public function createSlide(array $attributes): Slide;

    public function updateSlide(array $attributes): bool;

    public function deleteSlide(): bool;

    public function massDestroy(array $ids): bool;
}
