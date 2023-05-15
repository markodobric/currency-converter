<?php declare(strict_types=1);

namespace App\Models;

use App\Events\OrderCreated;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Currency $baseCurrency
 * @property float $base_currency_amount
 * @property Currency $foreignCurrency
 * @property float $foreign_currency_exchange_rate
 * @property float $foreign_currency_amount
 * @property float $surcharge_percentage
 * @property float $surcharge_amount
 * @property float $discount_percentage
 * @property float $discount_amount
 */
class Order extends BaseModel
{
    protected $dispatchesEvents = [
        'created' => OrderCreated::class,
    ];

    public function baseCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'base_currency_id');
    }

    public function foreignCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'foreign_currency_id');
    }
}
