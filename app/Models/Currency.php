<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Enum\CurrencyCode;

/**
 * @property string $name
 * @property CurrencyCode $code
 * @property float|null $surcharge
 * @property float|null $discount
 */
class Currency extends BaseModel
{
    protected $casts = [
        'code' => CurrencyCode::class,
    ];
}
