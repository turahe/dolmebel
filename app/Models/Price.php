<?php

declare(strict_types=1);
/*
 * This source code is the proprietary and confidential information of
 * Nur Wachid. You may not disclose, copy, distribute,
 *  or use this code without the express written permission of
 * Nur Wachid.
 *
 * Copyright (c) 2023.
 *
 *
 */

namespace App\Models;

use Turahe\Core\Concerns\HasConfigurablePrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Price extends Model
{
    use HasConfigurablePrimaryKey;
    use HasUserStamps;
    use SoftDeletes;


    protected $fillable = [
        'cogs',
        'sale',
        'currency',
        'metadata',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();

    }
}
