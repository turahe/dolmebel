<?php

namespace App\Contracts;

use App\Models\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface PipelineRepositoryInterface extends BaseRepositoryInterface
{
    public function listPipelines(array $columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    public function getPipelinesBuilder(string $orderBy = 'created_at', string $sortBy = 'desc'): Builder;

    public function createPipeline(string $name, string|int $value, ?string $code = null, Pipeline|string|int|null $parent = null, ?string $description = null): Pipeline;

    public function findPipeline(string $id): Pipeline;

    public function findPipelineByName(string $name): Pipeline;

    public function findPipelineByCode(string $code): Pipeline;

    public function findPipelineBySlug(string $slug): Pipeline;

    /**
     * @param  null  $description
     */
    public function updatePipeline(string $name, ?string $value = null, ?string $code = null, Pipeline|string|int|null $parent = null, $description = null): bool;

    public function deletePipeline(): bool;
}
