<?php

declare(strict_types=1);

namespace App\Models\Enum;

enum CurrencyCode: string
{
    case USD = 'USD';
    case JPY = 'JPY';
    case GBP = 'GBP';
    case EUR = 'EUR';
}
