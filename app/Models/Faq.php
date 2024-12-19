<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\FaqScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\Post\Models\Post;

#[ScopedBy([FaqScope::class])]
class Faq extends Post
{
    use SoftDeletes;

    /**
     * @psalm-suppress PossiblyUnusedProperty
     */
    protected function question(): Attribute
    {
        return Attribute::get(fn () => $this->title);

    }

    /**
     * @psalm-suppress PossiblyUnusedProperty
     */
    protected function answer(): Attribute
    {
        return Attribute::get(fn () => $this->description);

    }
}
