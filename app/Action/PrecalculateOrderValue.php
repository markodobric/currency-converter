<?php declare(strict_types=1);

namespace App\Action;

use App\Data\DecimalValue;
use App\Data\PurchaseData;
use App\Repository\CurrencyRepositoryInterface;
use App\Service\OrderCalculator\OrderCalculatorInterface;

class PrecalculateOrderValue
{
    public function __construct(
        private OrderCalculatorInterface $calculator,
        private CurrencyRepositoryInterface $currencyRepository
    ) {}

    public function __invoke(PurchaseData $data): DecimalValue
    {
        $from = $this->currencyRepository->find($data->from);
        $to = $this->currencyRepository->find($data->to);

        return $this->calculator
            ->calculate(new DecimalValue($data->amount), $from, $to)
            ->total;
    }
}
