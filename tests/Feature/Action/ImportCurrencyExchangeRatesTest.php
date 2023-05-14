<?php declare(strict_types=1);

namespace Tests\Feature\Action;

use App\Action\ImportCurrencyExchangeRates;
use App\Data\CurrencyExchangeRateDto;
use App\Data\RateDto;
use App\Models\Enum\CurrencyCode;
use App\Service\ExchangeRateServiceInterface;
use Mockery\MockInterface;
use Tests\IntegrationTestCase;

class ImportCurrencyExchangeRatesTest extends IntegrationTestCase
{
    private MockInterface $exchangeRateService;

    public function setUp(): void
    {
        parent::setUp();

        $this->exchangeRateService = $this->spy(ExchangeRateServiceInterface::class);
    }

    public function test_will_import_exchange_rates(): void
    {
        $this->assertDatabaseEmpty('currency_exchange_rates');

        $date = now();

        $this->exchangeRateService
            ->shouldReceive('getLatestExchangeRates')
            ->once()
            ->andReturn(
                new CurrencyExchangeRateDto(
                    code: CurrencyCode::USD,
                    date: $date,
                    rates: RateDto::collection([
                        [
                            'code' => CurrencyCode::GBP,
                            'rate' => 0.85,
                        ],
                        [
                            'code' => CurrencyCode::JPY,
                            'rate' => 112.85,
                        ],
                        [
                            'code' => CurrencyCode::EUR,
                            'rate' => 0.95,
                        ],
                    ])
                )
            );

        call_user_func($this->app->get(ImportCurrencyExchangeRates::class));

        $this->assertDatabaseHas(
            'currency_exchange_rates',
            [
                'base' => CurrencyCode::USD->value,
                'reference' => CurrencyCode::JPY->value,
                'date' => $date->format('Y-m-d'),
                'exchange_rate' => 112.85,
            ]
        );
        $this->assertDatabaseHas(
            'currency_exchange_rates',
            [
                'base' => CurrencyCode::USD->value,
                'reference' => CurrencyCode::GBP->value,
                'date' => $date->format('Y-m-d'),
                'exchange_rate' => 0.85,
            ]
        );
        $this->assertDatabaseHas(
            'currency_exchange_rates',
            [
                'base' => CurrencyCode::USD->value,
                'reference' => CurrencyCode::EUR->value,
                'date' => $date->format('Y-m-d'),
                'exchange_rate' => 0.95,
            ]
        );
    }
}
