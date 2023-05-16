<?php declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\Currency;
use App\Models\Enum\CurrencyCode;
use App\Repository\CurrencyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
{
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }

    public function findForeignCurrencies(): Collection
    {
        return Currency::where('code', '!=', CurrencyCode::USD->value)->get();
    }

    public function findByCode(CurrencyCode $code): ?Currency
    {
        return Currency::where('code', $code->value)->first();
    }
}
