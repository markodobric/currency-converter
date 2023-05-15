<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Enum\CurrencyCode;

/**
 * @property string $name
 * @property CurrencyCode $code
 * @property string|null $surcharge
 * @property string|null $discount
 */
class Currency extends BaseModel
{
    protected $casts = [
        'code' => CurrencyCode::class,
        'surcharge' => 'string',
        'discount' => 'string',
    ];

    public function hasSurcharge(): bool
    {
        return $this->surcharge !== null;
    }

    public function hasDiscount(): bool
    {
        return $this->discount !== null;
    }
}
