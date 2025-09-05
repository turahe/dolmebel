<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasPrice;
use App\Contracts\CartAble;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Turahe\Core\Concerns\HasConfigurablePrimaryKey;
use Turahe\Core\Concerns\HasTags;
use Turahe\Likeable\Traits\Likeable;
use Turahe\Media\HasMedia;
use Turahe\Post\Concerns\HasContents;
use Turahe\Post\Models\Post;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Service extends Model implements \Turahe\Likeable\Contracts\Likeable, CartAble
{
    use HasConfigurablePrimaryKey;
    use HasContents;
    use HasMedia;
    use HasPrice;
    use HasTags;
    use HasUserStamps;
    use Likeable;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'post_id',
        'code',
        'category_id',
    ];

    protected function casts()
    {
        return [
            'code' => 'string',
        ];
    }

    /**
     * @return array
     */
    public function toSearchableArray()
    {

        $array['slug'] = $this->post->slug;
        $array['title'] = $this->post->title;
        $array['subtitle'] = $this->post->subtitle;
        $array['description'] = $this->post->description;
        $array['content'] = $this->content_raw;
        $array['type'] = $this->post->type;
        $array['is_sticky'] = $this->post->is_sticky;
        $array['published_at'] = $this->post->published_at;
        $array['language'] = $this->post->language;
        $array['layout'] = $this->post->layout;
        $array['code'] = $this->code;
        $array['category'] = $this->category->name;
        $array['image'] = $this->image;
        $array['tags'] = $this->tags->pluck('name');
        $array['created_at'] = $this->created_at;

        return $array;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');

    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the URL to the post's image.
     */
    protected function image(): Attribute
    {
        return Attribute::get(fn () => $this->hasMedia('image') ? $this->getFirstMediaUrl('image') : $this->defaultImageUrl());
    }

    /**
     * Get the default post image URL if no image photo has been uploaded.
     */
    protected function defaultImageUrl(): string
    {
        return ' https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.urlencode($this->code);
    }
}
