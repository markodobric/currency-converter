<?php declare(strict_types=1);

namespace App\Service;

use App\Data\CurrencyExchangeRateDto;

interface ExchangeRateServiceInterface
{
    public function getLatestExchangeRates(): CurrencyExchangeRateDto;
}
