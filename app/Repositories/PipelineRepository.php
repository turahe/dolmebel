<?php

namespace App\Repositories;

use App\Contracts\PipelineRepositoryInterface;
use App\Models\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class PipelineRepository extends BaseRepository implements PipelineRepositoryInterface
{
    public function __construct(Pipeline $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function listPipelines(array $columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $this->getPipelinesBuilder($orderBy, $sortBy)->get()->except($columns);
    }

    public function getPipelinesBuilder(string $orderBy = 'created_at', string $sortBy = 'desc'): Builder
    {
        return $this->model->query()->orderBy($orderBy, $sortBy);
    }

    /**
     * @throws \Exception
     */
    public function createPipeline(string $name, string|int $value, ?string $code = null, Pipeline|string|int|null $parent = null, ?string $description = null): Pipeline
    {
        if ($parent instanceof Pipeline) {
            $parent = $parent->getKey();
        }
        if (is_null($code)) {
            $code = acronym($name);
        }
        $data = [
            'name' => $name,
            'code' => $code,
            'value' => $value,
            'parent_id' => $parent,
            'description' => $description,
        ];

        try {
            return $this->model->create($data);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function findPipelineBySlug(string $slug): Pipeline
    {
        try {
            return $this->model->where('slug', $slug)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function findPipeline(string $id): Pipeline
    {
        try {
            return $this->model->where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw (new ModelNotFoundException)->setModel(get_class($this->model));
        }
    }

    public function findPipelineByName(string $name): Pipeline
    {
        try {
            return $this->model->where('name', $name)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function findPipelineByCode(string $code): Pipeline
    {
        try {
            return $this->model->where('code', $code)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function updatePipeline(string $name, ?string $value = null, ?string $code = null, Pipeline|string|int|null $parent = null, $description = null): bool
    {
        if ($parent instanceof Pipeline) {
            $parent = $parent->getKey();
        }
        $data = [
            'name' => $name,
            'code' => $code,
            'value' => $value,
            'parent_id' => $parent,
            'description' => $description,
        ];

        try {
            return $this->model->update(array_filter($data));
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function deletePipeline(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $e) {
            throw new \Exception($e);
        }
    }
}
