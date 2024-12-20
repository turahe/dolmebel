<?php

namespace App\Http\Pipelines\QueryFilters\User;

use App\Http\Pipelines\QueryFilters\Filter;

class Search extends Filter
{
    protected function applyFilters($builder)
    {
        return $builder->where('username', 'LIKE', '%'.request($this->filterName()).'%')
            ->orWhere('phone', 'LIKE', '%'.request($this->filterName()).'%')
            ->orWhere('email', 'LIKE', '%'.request($this->filterName()).'%');
    }
}
