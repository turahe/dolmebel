<?php

namespace App\Http\Pipelines\QueryFilters\User;

use App\Http\Pipelines\QueryFilters\Filter;
use Illuminate\Database\Eloquent\Builder;

class Search extends Filter
{
    protected function applyFilters(Builder $builder): Builder
    {
        return $builder->where('username', 'LIKE', '%'.request($this->filterName()).'%')
            ->orWhere('phone', 'LIKE', '%'.request($this->filterName()).'%')
            ->orWhere('email', 'LIKE', '%'.request($this->filterName()).'%');
    }
}
