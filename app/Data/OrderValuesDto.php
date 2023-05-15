<?php declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

class OrderValuesDto extends Data
{
    public function __construct(
        public DecimalValue $convertedAmount,
        public DecimalValue $total,
        public string $exchangeRate,
        public ?DecimalValue $surchargeAmount = null,
        public ?string $surchargePercentage = null,
        public ?DecimalValue $discountAmount = null,
        public ?string $discountPercentage = null,
    ) {}
}
