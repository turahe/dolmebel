<?php

declare(strict_types=1);

namespace App\Models;

use Turahe\Core\Concerns\HasConfigurablePrimaryKey;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasConfigurablePrimaryKey;
    use HasUserStamps;
}
