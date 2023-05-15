<?php declare(strict_types=1);

namespace App\Action;

use App\Data\RateDto;
use App\Models\CurrencyExchangeRate;
use App\Service\ExchangeRate\ExchangeRateServiceInterface;

class ImportCurrencyExchangeRates
{
    public function __construct(private ExchangeRateServiceInterface $exchangeRateService)
    {
    }

    public function __invoke(): void
    {
        $exchangeRates = $this->exchangeRateService->getLatestExchangeRates();

        $rates = $exchangeRates
            ->rates
            ->toCollection()
            ->map(function (RateDto $rate) use ($exchangeRates) {
                return [
                    'base' => $exchangeRates->code->value,
                    'reference' => $rate->code->value,
                    'date' => $exchangeRates->date->format('Y-m-d'),
                    'exchange_rate' => $rate->rate,
                ];
            })->toArray();

        CurrencyExchangeRate::upsert($rates, ['base', 'reference', 'date'], ['exchange_rate']);
    }
}
