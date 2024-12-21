<?php

namespace App\Http\Pipelines\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class Search extends Filter
{
    protected function applyFilters(Builder $builder): Builder
    {
        return $builder->where('title', 'LIKE', '%'.request($this->filterName()).'%');
    }
}
