<?php declare(strict_types=1);

namespace App\Repository;

use App\Models\CurrencyExchangeRate;
use App\Models\Enum\CurrencyCode;
use Illuminate\Support\Carbon;

interface CurrencyExchangeRateRepositoryInterface extends RepositoryInterface
{
    public function findByBaseReferenceAndDate(
        CurrencyCode $base,
        CurrencyCode $reference,
        Carbon $date = new Carbon
    ): ?CurrencyExchangeRate;
}
