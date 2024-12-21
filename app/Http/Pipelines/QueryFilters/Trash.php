<?php

namespace App\Http\Pipelines\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class Trash extends Filter
{
    protected function applyFilters(Builder $builder): Builder
    {
        if (request()->has('trash') && request()->trash == 'true') {
            return $builder->withTrashed();
        }

        return $builder->onlyTrashed();
    }
}
