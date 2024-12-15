<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Email;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasEmail
{
    /**
     * Boot the HasEmail trait
     */
    protected static function bootHasEmail(): void
    {
        static::deleting(function ($model): void {
            $model->emails()->delete();
        });
    }

    public function getEmail(): Collection
    {
        return $this->emails;
    }

    public function setEmail(string $email): Email
    {
        return $this->emails()->create([
            'address' => $email,
        ]);
    }

    public function emails(): MorphMany
    {
        return $this->morphMany(Email::class, 'model');

    }

    /**
     * Scope a query to include records by phone.
     */
    public function scopeByEmail(Builder $query, string $email): void
    {
        $query->whereHas('emails', function ($query) use ($email) {
            return $query->where('address', $email);
        });
    }
}
