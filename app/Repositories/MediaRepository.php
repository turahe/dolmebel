<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\MediaRepositoryInterface;
use App\Models\Media;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class MediaRepository extends BaseRepository implements MediaRepositoryInterface
{
    public function __construct(Media $model)
    {
        parent::__construct($model);
        $this->model = $model;

    }

    /**
     * @return \Kalnoy\Nestedset\Collection
     */
    public function getMedias(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * @throws Exception
     */
    public function getMedia(string $id): Media
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function getMediaByName($name): Media
    {
        try {
            return $this->model->where('name', $name)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function getMediaBySlug($slug): Media
    {
        try {
            return $this->model->where('slug', $slug)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function createMedia(array $attributes): Media
    {
        try {
            return $this->model->create($attributes);
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function updateMedia(array $attributes): bool
    {
        try {
            return $this->model->update($attributes);
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }

    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function deleteMedia(string $id): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
