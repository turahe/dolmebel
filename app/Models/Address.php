<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\Core\Concerns\HasConfigurablePrimaryKey;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Address extends Model
{
    use HasConfigurablePrimaryKey;
    use HasUserStamps;
    use SoftDeletes;

    protected $fillable = [
        'model_type',
        'model_id',
        'label',
        'is_primary',
        'is_billing',
        'is_shipping',
        'street_address1',
        'street_address2',
        'zip',
        'city',
        'state',
        'country',
        'country_code',
    ];
}
