<?php declare(strict_types=1);

namespace App\Service\CurrencyConverter;

use App\Data\DecimalValue;
use App\Models\CurrencyExchangeRate;

interface CurrencyConverterServiceInterface
{
    public function convert(DecimalValue $amount, CurrencyExchangeRate $currencyExchangeRate): DecimalValue;
}
