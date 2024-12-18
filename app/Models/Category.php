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
use Illuminate\Support\Facades\Storage;
use Turahe\Media\HasMedia;

class Category extends \Turahe\Core\Models\Taxonomy
{
    use HasMedia;

    /**
     * Get the URL to the user's profile photo.
     */
    public function image(): Attribute
    {
        return Attribute::make(get: fn () => $this->hasMedia('image')
            ? $this->getFirstMediaUrl('image')
            : $this->defaultImageUrl())->shouldCache();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     */
    protected function defaultImageUrl(): string
    {
        return Storage::url('product-default.png');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');

    }
}
