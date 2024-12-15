<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Price;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPrice
{
    /**
     * Boot the HasPrice trait
     */
    protected static function bootHasPrice(): void
    {
        static::deleting(function ($model): void {
            $model->prices()->delete();
        });
    }

    public function prices(): MorphMany
    {
        return $this->morphMany(Price::class, 'model');
    }

    public function getPrice(): float
    {
        return (float) $this->price->sale;
    }

    public function getCurrency(): string
    {
        return (string) $this->price->currency;
    }

    public function getCOGS(): float
    {
        return (float) $this->price->cogs;
    }

    public function price(): Attribute
    {
        return Attribute::get(fn () => $this->prices->last());

    }

    public function setPrice(int|float $price, int|float|null $cogs = null, string $currency = 'IDR'): Price
    {
        if (is_null($cogs)) {
            $cogs = $price;
        }

        return $this->prices()->create([
            'sale' => $price,
            'cogs' => $cogs,
            'currency' => $currency,
        ]);

    }
}
