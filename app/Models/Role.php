<?php

declare(strict_types=1);

namespace App\Models;

use Turahe\Core\Concerns\HasConfigurablePrimaryKey;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Role extends \Spatie\Permission\Models\Role
{
    use HasConfigurablePrimaryKey;
    use HasUserStamps;
}
