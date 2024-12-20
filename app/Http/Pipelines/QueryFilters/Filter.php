<?php

namespace App\Http\Pipelines\QueryFilters;

use Illuminate\Support\Str;

abstract class Filter
{
    /**
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (! request()->has($this->filterName())) {
            return $next($request);
        }

        $builder = $next($request);

        return $this->applyFilters($builder);
    }

    /**
     * @return mixed
     */
    abstract protected function applyFilters($builder);

    protected function filterName(): string
    {
        return Str::snake(class_basename($this));
    }
}
