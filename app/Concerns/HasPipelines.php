<?php

namespace App\Concerns;

use App\Contracts\PipelineRepositoryInterface;
use App\Models\Pipeline;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasPipelines
{
    /**
     * Boot the HasPipelines trait
     */
    protected static function bootHasPipelines(): void
    {
        static::deleting(function ($model): void {
            $model->pipelines()->detach();
        });
    }

    /**
     * Return a collection of pipelines for this model.
     */
    public function pipelines(): MorphToMany
    {
        return $this->morphToMany(
            Pipeline::class,
            'model',
            'model_has_pipelines',
            'model_id',
            'pipeline_id',

        )->withTimestamps();
    }

    /**
     * Convenience method to add category to this model.
     */
    public function addPipeline(string $code)
    {
        $pipeline = app(PipelineRepositoryInterface::class)->findPipelineByCode($code);
        $this->pipelines()->attach($pipeline);
    }

    /**
     * Get a term model by the given code and optionally a pipeline.
     */
    public function getPipeline(string $code): ?Pipeline
    {

        return $this->pipelines->where('code', $code)->first();
    }

    /**
     * Check if this model belongs to a given category.
     */
    public function hasPipeline(string $code): bool
    {
        return (bool) $this->getPipeline($code);
    }

    public function detachPipeline(): bool
    {
        return $this->pipelines()->detach();

    }
}
