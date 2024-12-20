<?php

namespace App\Http\Pipelines\QueryFilters;

class ParentId extends Filter
{
    protected function applyFilters($builder)
    {
        return $builder->where('parent_id', request($this->filterName()));
    }
}
