<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\SlideRepositoryInterface;
use App\Models\Slide;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class SlideRepository extends BaseRepository implements SlideRepositoryInterface
{
    public function __construct(Slide $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getSlides(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getSlidesBuilder($order, $sort)->get()->except($except);
    }

    public function getSlidesBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()
            ->with('media')
            ->orderBy($order, $sort);
    }

    public function getSlide(string $id): Slide
    {
        try {
            return $this->model->where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function createSlide(array $attributes): Slide
    {
        try {
            return $this->model->create($this->formatInput($attributes));
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function updateSlide(array $attributes): bool
    {
        try {
            return $this->model->update($this->formatInput($attributes));
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function deleteSlide(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function trashSlide(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function massDestroy(array $ids): bool
    {
        try {
            return (bool) $this->model->whereIn('id', $ids)->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function formatInput(array $data): array
    {
        $data['type'] = 'slide';
        $data['layout'] = 'slide';
        if (empty($data['language'])) {
            $data['language'] = config('app.locale');
        }

        return array_filter($data);
    }
}
