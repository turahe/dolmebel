<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\PageScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\Post\Concerns\HasContents;
use Turahe\Post\Models\Post;

#[ScopedBy([PageScope::class])]
class Page extends Post
{
    use HasContents;
    use SoftDeletes;
}
