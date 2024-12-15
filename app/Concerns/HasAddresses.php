<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Address;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAddresses
{
    /**
     * Boot the HasAddresses trait
     */
    public static function bootHasAddresses(): void
    {
        static::deleted(function ($model): void {
            $model->addresses()->delete();
        });
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }

    public function addAddress(array $attributes)
    {
        return $this->addresses()->create($attributes);

    }
}
