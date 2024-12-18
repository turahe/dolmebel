<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PhoneType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Phone extends Model
{
    use HasUlids;
    use HasUserStamps;
    use SoftDeletes;

    protected $table = 'model_phones';

    public $dateFormat = 'U';

    protected $fillable = [
        'number',
        'type',
        'country_id',
    ];

    protected function casts()
    {
        return [
            'type' => PhoneType::class,
        ];
    }
}
