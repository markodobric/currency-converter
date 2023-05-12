<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Enum\CurrencyCode;
use App\Service\ApiLayer\ApiLayerConnectorService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\TestCase;

class ApiLayerConnectorServiceTest extends TestCase
{
    public function test_connector_will_send_http_request(): void
    {
        Http::shouldReceive('withHeaders')
            ->once()
            ->with(
                [
                    'Content-Type' => 'application/json',
                    'apikey' => 'api-key-value',
                ]
            )
            ->andReturnSelf();
        Http::shouldReceive('get')
            ->once()
            ->with(
                ApiLayerConnectorService::APILAYER_API_URL,
                [
                    'base' => CurrencyCode::USD->value,
                    'symbols' => sprintf(
                        '%s,%s,%s',
                        CurrencyCode::GBP->value,
                        CurrencyCode::JPY->value,
                        CurrencyCode::EUR->value
                    )
                ]
            )->andReturn($this->createMock(Response::class));

        call_user_func(
            new ApiLayerConnectorService('api-key-value'),
            CurrencyCode::USD,
            collect([CurrencyCode::GBP, CurrencyCode::JPY, CurrencyCode::EUR])
        );
    }
}
