<?php declare(strict_types=1);

namespace App\Data;

use App\Models\Enum\CurrencyCode;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CurrencyExchangeRateDto extends Data
{
    public function __construct(
        public readonly CurrencyCode $code,
        public readonly Carbon $date,
        #[DataCollectionOf(RateDto::class)]
        public readonly DataCollection $rates
    ) {}
}
