<?php declare(strict_types=1);

namespace Tests\Feature\Service;

use App\Data\DecimalValue;
use App\Data\OrderValuesDto;
use App\Exceptions\CurrencyExchangeRateDoesNotExistException;
use App\Models\Currency;
use App\Models\CurrencyExchangeRate;
use App\Service\OrderCalculator\OrderCalculatorInterface;
use Tests\IntegrationTestCase;

class OrderCalculatorTest extends IntegrationTestCase
{
    private Currency $currency1;
    private Currency $currency2;

    public function setUp(): void
    {
        parent::setUp();

        $this->currency1 = Currency::factory()->create();
        $this->currency2 = Currency::factory()->eur()->create();
    }

    public function test_will_throw_exception_if_exchange_rate_does_not_exist(): void
    {
        $this->expectException(CurrencyExchangeRateDoesNotExistException::class);

        $this->assertDatabaseEmpty('currency_exchange_rates');

        $this->app->get(OrderCalculatorInterface::class)->calculate(
            new DecimalValue('100'),
            $this->currency1,
            $this->currency2
        );
    }

    public function test_calculation_without_surcharge_and_discount(): void
    {
        $this->assertFalse($this->currency2->hasSurcharge());
        $this->assertFalse($this->currency2->hasDiscount());

        CurrencyExchangeRate::factory()->create();

        /** @var OrderValuesDto $result */
        $result = app(OrderCalculatorInterface::class)->calculate(
            new DecimalValue('100'),
            $this->currency1,
            $this->currency2
        );

        $this->assertSame('86.230000', $result->convertedAmount->value);
        $this->assertSame('86.230000', $result->total->value);
        $this->assertNull($result->surchargeAmount);
        $this->assertNull($result->discountAmount);
    }

    public function test_calculation_with_surcharge_and_without_discount(): void
    {
        $this->currency2->update(['surcharge' => 5.0]);

        $this->assertTrue($this->currency2->hasSurcharge());
        $this->assertFalse($this->currency2->hasDiscount());

        CurrencyExchangeRate::factory()->create();

        /** @var OrderValuesDto $result */
        $result = app(OrderCalculatorInterface::class)->calculate(
            new DecimalValue('100'),
            $this->currency1,
            $this->currency2
        );

        $this->assertSame('86.230000', $result->convertedAmount->value);
        $this->assertSame('90.540000', $result->total->value);
        $this->assertSame('0.862300', $result->exchangeRate);
        $this->assertSame('4.310000', $result->surchargeAmount->value);
        $this->assertSame('5', $result->surchargePercentage);
        $this->assertNull($result->discountPercentage);
        $this->assertNull($result->discountAmount);
    }

    public function test_calculation_with_surcharge_and_discount(): void
    {
        $this->currency2->update(['surcharge' => 5.0, 'discount' => 2.0]);

        $this->assertTrue($this->currency2->hasSurcharge());
        $this->assertTrue($this->currency2->hasDiscount());

        CurrencyExchangeRate::factory()->create();

        /** @var OrderValuesDto $result */
        $result = app(OrderCalculatorInterface::class)->calculate(
            new DecimalValue('100'),
            $this->currency1,
            $this->currency2
        );

        $this->assertSame('86.230000', $result->convertedAmount->value);
        $this->assertSame('88.730000', $result->total->value);
        $this->assertSame('0.862300', $result->exchangeRate);
        $this->assertSame('4.310000', $result->surchargeAmount->value);
        $this->assertSame('5', $result->surchargePercentage);
        $this->assertSame('2', $result->discountPercentage);
        $this->assertSame('1.810000', $result->discountAmount->value);
    }
}
