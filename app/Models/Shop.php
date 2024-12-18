<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasAddresses;
use App\Concerns\HasBanks;
use App\Concerns\HasPhones;
use App\Models\Scopes\ShopScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Turahe\Core\Models\Organization;

#[ScopedBy([ShopScope::class])]

class Shop extends Organization {
    use HasAddresses;
    use HasPhones;
    use HasBanks;
}
