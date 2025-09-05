<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PhoneType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\Core\Concerns\HasConfigurablePrimaryKey;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Phone extends Model
{
    use HasConfigurablePrimaryKey;
    use HasUserStamps;
    use SoftDeletes;

    protected $table = 'model_phones';

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
