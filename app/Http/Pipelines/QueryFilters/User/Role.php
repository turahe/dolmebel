<?php

namespace App\Http\Pipelines\QueryFilters\User;

use App\Http\Pipelines\QueryFilters\Filter;
use Illuminate\Database\Eloquent\Builder;

class Role extends Filter
{
    protected function applyFilters(Builder $builder): Builder
    {
        return $builder->whereHas('roles', function ($query) {
            $query->where('name', request($this->filterName()));
        });
    }
}
