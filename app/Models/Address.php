<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Address extends \Masterix21\Addressable\Models\Address
{
    use HasUlids;
    use HasUserStamps;
    use SoftDeletes;

    protected $dateFormat = 'U';
}
