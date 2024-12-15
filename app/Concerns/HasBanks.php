<?php

namespace App\Concerns;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasBanks
{
    /**
     * Boot the HasBanks trait
     */
    public static function bootHasBanks(): void
    {
        static::deleted(function ($model): void {
            $model->banks()->delete();
        });
    }

    public function banks(): MorphMany
    {
        return $this->morphMany(Bank::class, 'holder');

    }

    public function addBank(array $attributes)
    {
        return $this->banks()->create($attributes);

    }
}
