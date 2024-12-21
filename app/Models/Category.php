<?php

declare(strict_types=1);
/*
 * This source code is the proprietary and confidential information of
 * Nur Wachid. You may not disclose, copy, distribute,
 *  or use this code without the express written permission of
 * Nur Wachid.
 *
 * Copyright (c) 2023.
 *
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Turahe\Media\HasMedia;

class Category extends \Turahe\Core\Models\Taxonomy
{
    use HasMedia;

    /**
     * Get the URL to the user's profile photo.
     */
    protected function image(): Attribute
    {
        return Attribute::make(get: fn () => $this->hasMedia('image')
            ? $this->getFirstMediaUrl('image')
            : $this->defaultImageUrl());
    }

    /**
     * Get the URL to the user's profile photo.
     */
    protected function icon(): Attribute
    {
        return Attribute::make(get: fn () => $this->hasMedia('icon')
            ? $this->getFirstMediaUrl('icon')
            : $this->defaultIconUrl());
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     */
    private function defaultImageUrl(): string
    {
        return Storage::url('images/category.png');
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     */
    private function defaultIconUrl(): string
    {
        return Storage::url('images/category.svg');
    }

    public function blogs()
    {
        return $this->morphedByMany(
            Blog::class,
            'model',
            'model_has_taxonomies',
            'model_id',
            'taxonomy_id',
        );

    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');

    }
}
