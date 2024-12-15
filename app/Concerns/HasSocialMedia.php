<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\SocialMedia;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasSocialMedia
{
    /**
     * Boot the HasSocialMedia trait
     */
    protected static function bootHasSocialMedia(): void
    {
        static::deleting(function ($model): void {
            $model->social_media()->delete();
        });
    }

    public function linkSocialMedia(): Collection
    {
        return $this->social_media;
    }

    public function setSocialMedia(string $name, string $link): SocialMedia
    {
        return $this->social_media()->create([
            'link' => $link,
            'name' => $name,
        ]);
    }

    public function social_media(): MorphMany
    {
        return $this->morphMany(SocialMedia::class, 'model');

    }
}
