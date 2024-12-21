<?php

/*
 * DolMebel - https://www.dolmebel.com
 *
 * @version   1.0.0
 *
 * @link      Releases - https://www.wach.id/releases
 * @link      Terms Of Service - https://www.wach.id/terms
 *
 * Copyright (c) 2024.
 *
 */

namespace App\Http\Pipelines\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class BrandId extends Filter
{
    protected function applyFilters(Builder $builder): Builder
    {
        return $builder->where('brand_id', request($this->filterName()));
    }
}
