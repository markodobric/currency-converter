<?php declare(strict_types=1);

namespace App\Repository;

use App\Models\Currency;
use App\Models\Enum\CurrencyCode;
use Illuminate\Database\Eloquent\Collection;

interface CurrencyRepositoryInterface extends RepositoryInterface
{
    public function findForeignCurrencies(): Collection;

    public function findByCode(CurrencyCode $code): ?Currency;
}
