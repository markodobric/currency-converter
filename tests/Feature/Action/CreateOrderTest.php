<?php declare(strict_types=1);

namespace Tests\Feature\Action;

use App\Action\CreateOrder;
use App\Data\DecimalValue;
use App\Data\PurchaseData;
use App\Models\Currency;
use App\Models\CurrencyExchangeRate;
use Tests\IntegrationTestCase;

class CreateOrderTest extends IntegrationTestCase
{
    private Currency $currency1;
    private Currency $currency2;

    public function setUp(): void
    {
        parent::setUp();

        $this->currency1 = Currency::factory()->create();
        $this->currency2 = Currency::factory()->eur()->create();

        CurrencyExchangeRate::factory()->create();
    }

    public function test_will_create_order(): void
    {
        $order = call_user_func(
            $this->app->get(CreateOrder::class),
            new PurchaseData(
                $this->currency1->id,
                $this->currency2->id,
                new DecimalValue('232')
            )
        );

        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }
}
