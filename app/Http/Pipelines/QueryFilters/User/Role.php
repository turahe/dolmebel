<?php

namespace App\Http\Pipelines\QueryFilters\User;

use App\Http\Pipelines\QueryFilters\Filter;

class Role extends Filter
{
    protected function applyFilters($builder)
    {
        return $builder->whereHas('roles', function ($query) {
            $query->where('name', request($this->filterName()));
        });
    }
}
