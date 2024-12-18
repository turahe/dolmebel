<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasUlids;
    use HasUserStamps;

    protected $dateFormat = 'U';
}
