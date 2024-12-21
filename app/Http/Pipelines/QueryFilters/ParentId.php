<?php

namespace App\Http\Pipelines\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class ParentId extends Filter
{
    protected function applyFilters(Builder $builder): Builder
    {
        if (request($this->filterName()) === 'notNull') {
            return $builder->whereNotNull('parent_id');
        }

        return $builder->where('parent_id', request($this->filterName()));
    }
}
