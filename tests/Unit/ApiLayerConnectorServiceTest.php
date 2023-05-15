<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\UnableToFetchExchangeRateException;
use App\Models\Enum\CurrencyCode;
use App\Service\ExchangeRate\ApiLayer\ApiLayerConnectorService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Mockery\MockInterface;
use Tests\TestCase;

class ApiLayerConnectorServiceTest extends TestCase
{
    private MockInterface $response;

    public function setUp(): void
    {
        parent::setUp();

        $this->response = $this->spy(Response::class);

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
            )->andReturn($this->response);
    }

    public function test_connector_will_throw_ecception(): void
    {
        $this->expectException(UnableToFetchExchangeRateException::class);

        $this->response
            ->shouldReceive('successful')
            ->once()
            ->andReturn(false);
        $this->response
            ->shouldNotReceive('json');

        call_user_func(
            new ApiLayerConnectorService('api-key-value'),
            CurrencyCode::USD,
            collect([CurrencyCode::GBP, CurrencyCode::JPY, CurrencyCode::EUR])
        );
    }

    public function test_connector_will_send_http_request(): void
    {
        $this->response
            ->shouldReceive('successful')
            ->once()
            ->andReturn(true);
        $this->response
            ->shouldReceive('json')
            ->once()
            ->andReturn([]);

        call_user_func(
            new ApiLayerConnectorService('api-key-value'),
            CurrencyCode::USD,
            collect([CurrencyCode::GBP, CurrencyCode::JPY, CurrencyCode::EUR])
        );
    }
}
