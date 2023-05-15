<?php declare(strict_types=1);

namespace App\Service\CurrencyConverter;

use App\Data\DecimalValue;
use App\Models\CurrencyExchangeRate;

class CurrencyConverterService implements CurrencyConverterServiceInterface
{
    public function convert(DecimalValue $amount, CurrencyExchangeRate $currencyExchangeRate): DecimalValue
    {
        $from = $currencyExchangeRate->base->value;
        $to = $currencyExchangeRate->reference->value;

        if ($from === $to) {
            return $amount;
        }

        return new DecimalValue(
            bcmul(
                $amount->value,
                $currencyExchangeRate->exchange_rate,
                6
            )
        );
    }
}
