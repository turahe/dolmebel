<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Transaction extends \MannikJ\Laravel\Wallet\Models\Transaction
{
    use HasUlids;

    protected $dateFormat = 'U';
}
