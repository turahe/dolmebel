<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\Media\HasMedia;
use Turahe\Post\Models\Post;

class Slide extends Post
{
    use HasMedia;
    use SoftDeletes;

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
        $title = trim(collect(explode(' ', $this->title))->map(fn ($segment) => mb_substr($segment, 0, 1))->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($title).'&color=7F9CF5&background=EBF4FF';
    }
}
