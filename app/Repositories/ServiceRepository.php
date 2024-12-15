<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ServiceRepositoryInterface;
use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Turahe\Core\Repositories\BaseRepository;
use Turahe\Post\Models\Post;

class ServiceRepository extends BaseRepository implements ServiceRepositoryInterface
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getServices(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    public function getService(string $id): Service
    {
        try {
            return $this->model->where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function getServiceBySlug(string $slug): Service
    {
        try {
            return $this->model->whereHas('post', function (Builder $builder) use ($slug): void {
                $builder->where('slug', $slug);
            })->first();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @throws \Throwable
     */
    public function createService(array $attributes): Service
    {
        return DB::transaction(function () use ($attributes) {
            $post = Post::create([
                'title' => $attributes['title'],
                'subtitle' => $attributes['subtitle'] ?? null,
                'description' => $attributes['description'] ?? null,
                'type' => 'service',
            ]);

            return $this->model->create([
                'code' => $attributes['code'],
                'category_id' => $attributes['category_id'],
                'post_id' => $post->id,
            ]);
        });
    }

    /**
     * @throws \Throwable
     */
    public function updateService(array $attributes): bool
    {
        $post = array_filter([
            'title' => $attributes['title'] ?? null,
            'subtitle' => $attributes['subtitle'] ?? null,
            'description' => $attributes['description'] ?? null,
            'type' => 'service',
        ]);
        $service = array_filter([
            'code' => $attributes['code'] ?? null,
            'category_id' => $attributes['category_id'] ?? null,
        ]);

        return DB::transaction(function () use ($service, $post) {
            if (isset($post['title']) || isset($post['subtitle']) || isset($post['description'])) {
                Post::where('post_id', $this->model->getKey())->update($post);
            }

            return $this->model->update($service);
        });
    }

    /**
     * @throws \Exception
     */
    public function deleteService(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function trashService(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage());
        }

    }
}
