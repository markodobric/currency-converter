<?php declare(strict_types=1);

namespace App\Action;

use App\Data\DecimalValue;
use App\Models\Currency;
use App\Models\Order;
use App\Service\OrderCalculator\OrderCalculatorInterface;

class CreateOrder
{
    public function __construct(private OrderCalculatorInterface $orderCalculator)
    {}

    public function __invoke(DecimalValue $amount, Currency $from, Currency $to): Order
    {
        $values = $this->orderCalculator->calculate($amount, $from, $to);

        return Order::create(
            [
                'base_currency_id' => $from->id,
                'foreign_currency_id' => $to->id,
                'base_currency_amount' => $amount->value,
                'foreign_currency_amount' => $values->convertedAmount->value,
                'foreign_currency_exchange_rate' => $values->exchangeRate,
                'surcharge_percentage' => $values->surchargePercentage,
                'surcharge_amount' => $values->surchargeAmount?->value,
                'discount_percentage' => $values->discountPercentage,
                'discount_amount' => $values->discountAmount?->value,
                'total' => $values->total->value,
            ]
        );
    }
}
