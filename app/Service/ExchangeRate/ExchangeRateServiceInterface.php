<?php declare(strict_types=1);

namespace App\Service\ExchangeRate;

use App\Data\CurrencyExchangeRateDto;

interface ExchangeRateServiceInterface
{
    public function getLatestExchangeRates(): CurrencyExchangeRateDto;
}
