<?php declare(strict_types=1);

namespace Tests\Feature\Service;

use App\Data\DecimalValue;
use App\Models\CurrencyExchangeRate;
use App\Service\CurrencyConverter\CurrencyConverterServiceInterface;
use Tests\IntegrationTestCase;

class CurrencyConverterServiceTest extends IntegrationTestCase
{
    public function test_currency_converter(): void
    {
        /** @var CurrencyExchangeRate $exchangeRate */
        $exchangeRate = CurrencyExchangeRate::factory()->create();

        $this->assertSame('0.8623', $exchangeRate->exchange_rate);

        $result = app(CurrencyConverterServiceInterface::class)->convert(
            new DecimalValue('100'),
            $exchangeRate
        );

        $this->assertSame('86.230000', $result->value);
    }
}
