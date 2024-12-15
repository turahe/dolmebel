<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Enums\PhoneType;
use App\Models\Phone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasPhones
{
    /**
     * Boot the HasPhones trait
     */
    protected static function bootHasPhones(): void
    {
        static::deleting(function ($model): void {
            $model->phones()->delete();
        });
    }

    public function getPhone(): Collection
    {
        return $this->phones;
    }

    public function setPhone(string $phone, ?PhoneType $type = null, string $country = 'ID'): Phone
    {
        $number = parse_phone($phone, $country);

        return $this->phones()->create([
            'number' => $number,
            'type' => $type,
            'country_id' => $country,
        ]);
    }

    public function phones(): MorphMany
    {
        return $this->morphMany(Phone::class, 'model')->orderBy('created_at');

    }

    /**
     * Scope a query to include records by phone.
     */
    public function scopeByPhone(Builder $query, string $phone, ?PhoneType $type = null): void
    {
        $query->whereHas('phones', function ($query) use ($phone, $type) {
            if ($type) {
                $query->where('type', $type);
            }

            return $query->where('number', $phone);
        });
    }
}
