<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\BlogScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\Comment\Concerns\HasComments;
use Turahe\Media\HasMedia;
use Turahe\Post\Concerns\HasContents;
use Turahe\Post\Models\Post;

#[ScopedBy([BlogScope::class])]

class Blog extends Post
{
    use HasComments;
    use HasContents;
    use HasMedia;
    use SoftDeletes;

    /**
     * Get the URL to the post's image.
     */
    protected function image(): Attribute
    {
        return Attribute::get(fn () => $this->hasMedia('image') ? $this->getFirstMediaUrl('image') : null);
    }
}
