<?php

declare(strict_types=1);

namespace App\Contracts;

interface CartAble
{
    public function getPrice(): float;
}
