<?php declare(strict_types=1);

namespace App\Data;

use App\Models\Enum\CurrencyCode;
use Spatie\LaravelData\Data;

class RateDto extends Data
{
    public function __construct(
        public readonly CurrencyCode $code,
        public readonly float $rate,
    ) {}
}
