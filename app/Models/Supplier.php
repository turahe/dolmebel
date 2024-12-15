<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\SupplierScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([SupplierScope::class])]
class Supplier extends Organization {}
