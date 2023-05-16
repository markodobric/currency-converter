<?php declare(strict_types=1);

namespace App\Action;

use App\Data\DecimalValue;
use App\Data\PurchaseData;
use App\Models\Currency;
use App\Models\Order;
use App\Repository\CurrencyRepositoryInterface;
use App\Service\OrderCalculator\OrderCalculatorInterface;

class CreateOrder
{
    public function __construct(
        private OrderCalculatorInterface $orderCalculator,
        private CurrencyRepositoryInterface $currencyRepository
    ) {}

    public function __invoke(PurchaseData $data): Order
    {
        $from = $this->currencyRepository->find($data->from);
        $to = $this->currencyRepository->find($data->to);

        $values = $this->orderCalculator->calculate(new DecimalValue($data->amount), $from, $to);

        return Order::create(
            [
                'base_currency_id' => $from->id,
                'foreign_currency_id' => $to->id,
                'base_currency_amount' => $data->amount,
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
