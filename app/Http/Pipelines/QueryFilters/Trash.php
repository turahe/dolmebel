<?php

namespace App\Http\Pipelines\QueryFilters;

class Trash extends Filter
{
    protected function applyFilters($builder)
    {
        if (request()->has('trash') && request()->trash == 'true') {
            return $builder->withTrashed();
        }

        return $builder->onlyTrashed();
    }
}
