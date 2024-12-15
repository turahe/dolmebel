<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Wallet extends \MannikJ\Laravel\Wallet\Models\Wallet
{
    use HasUlids;

    protected $dateFormat = 'U';
}
