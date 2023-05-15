<?php declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\CurrencyExchangeRate;
use App\Models\Enum\CurrencyCode;
use App\Repository\CurrencyExchangeRateRepositoryInterface;
use Illuminate\Support\Carbon;

class CurrencyExchangeRateRepository extends BaseRepository implements CurrencyExchangeRateRepositoryInterface
{
    public function __construct(CurrencyExchangeRate $model)
    {
        parent::__construct($model);
    }

    public function findByBaseReferenceAndDate(
        CurrencyCode $base,
        CurrencyCode $reference,
        Carbon $date = new Carbon
    ): ?CurrencyExchangeRate
    {
        return CurrencyExchangeRate::where(
            [
                ['base', '=', $base->value],
                ['reference', '=', $reference->value],
                ['date', '=', $date->format('Y-m-d')],
            ]
        )->first();
    }
}
