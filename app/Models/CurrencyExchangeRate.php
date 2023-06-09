<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Enum\CurrencyCode;
use Illuminate\Support\Carbon;

/**
 * @property CurrencyCode $base
 * @property CurrencyCode $reference
 * @property Carbon $date
 * @property string $exchange_rate
 */
class CurrencyExchangeRate extends BaseModel
{
    protected $casts = [
        'base' => CurrencyCode::class,
        'reference' => CurrencyCode::class,
        'exchange_rate' => 'string',
    ];
}
