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

use App\Concerns\HasPrice;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Turahe\Core\Concerns\HasTags;
use Turahe\Likeable\Traits\Likeable;
use Turahe\Media\HasMedia;
use Turahe\Post\Concerns\HasContents;
use Turahe\Post\Models\Post;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Product extends Model implements \Turahe\Likeable\Contracts\Likeable
{
    use HasContents;
    use HasMedia;
    use HasPrice;
    use HasTags;
    use HasUlids;
    use HasUserStamps;
    use Likeable;
    use Searchable;
    use SoftDeletes;

    /**
     * @var string
     */
    public $dateFormat = 'U';

    /**
     * @var string[]
     */
    protected $fillable = [
        'qrcode',
        'barcode',
        'post_id',
        'category_id',
        'supplier_id',
        'brand_id',
        'manufacturer_id',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        $array['qrcode'] = $this->qrcode;
        $array['barcode'] = $this->barcode;
        $array['category'] = $this->category->name;
        $array['supplier'] = $this->supplier?->name;
        $array['brand'] = $this->brand?->name;
        $array['slug'] = $this->post->slug;
        $array['title'] = $this->post->title;
        $array['subtitle'] = $this->post->subtitle;
        $array['description'] = $this->post->description;
        $array['content'] = $this->content_raw;
        $array['prices'] = $this->prices->pluck(['currency', 'cogs', 'sale'])->toArray();
        $array['options'] = $this->options;

        return $array;
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function manufacture(): BelongsTo
    {
        return $this->belongsTo(Manufacture::class, 'manufacture_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function option_groups(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_options', 'product_id', 'option_group_id');
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_options', 'product_id', 'option_id');
    }
}
