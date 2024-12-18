<?php

declare(strict_types=1);

namespace App\Enums;

enum PhoneType: string
{
    case Mobile = 'MOBILE';
    case Work = 'WORK';
    case Other = 'OTHER';

}
