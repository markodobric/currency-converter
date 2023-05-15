<?php declare(strict_types=1);

namespace App\Service\OrderCalculator;

use App\Data\DecimalValue;
use App\Data\OrderValuesDto;
use App\Models\Currency;

interface OrderCalculatorInterface
{
    public function calculate(DecimalValue $amount, Currency $from, Currency $to): OrderValuesDto;
}
