<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasAddresses;
use App\Concerns\HasBanks;
use App\Concerns\HasPhones;
use App\Models\Scopes\SupplierScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Turahe\Core\Models\Organization;

#[ScopedBy([SupplierScope::class])]
class Supplier extends Organization
{
    use HasAddresses;
    use HasBanks;
    use HasPhones;
}
