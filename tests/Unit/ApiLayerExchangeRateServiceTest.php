<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Data\CurrencyExchangeRateDto;
use App\Exceptions\UnableToFetchExchangeRateException;
use App\Models\Enum\CurrencyCode;
use App\Service\ExchangeRate\ApiLayer\ApiLayerConnectorService;
use App\Service\ExchangeRate\ApiLayer\ApiLayerExchangeRateService;
use App\Service\ExchangeRate\ExchangeRateServiceInterface;
use Illuminate\Http\Client\ConnectionException;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

class ApiLayerExchangeRateServiceTest extends TestCase
{
    private MockObject $apiLayerConnectorService;
    private MockObject $logger;
    private ExchangeRateServiceInterface $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->apiLayerConnectorService = $this->createMock(ApiLayerConnectorService::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->service = new ApiLayerExchangeRateService($this->apiLayerConnectorService, $this->logger);
    }

    public function test_service_will_throw_exception(): void
    {
        $this->expectException(UnableToFetchExchangeRateException::class);

        $this->apiLayerConnectorService
            ->expects($this->once())
            ->method('__invoke')
            ->with(
                CurrencyCode::USD,
                collect([CurrencyCode::GBP, CurrencyCode::JPY, CurrencyCode::EUR])
            )->willThrowException(new ConnectionException);

        $this->service->getLatestExchangeRates();
    }

    public function test_service_will_map_data_to_dto2(): void
    {
        $this->apiLayerConnectorService
            ->expects($this->once())
            ->method('__invoke')
            ->with(
                CurrencyCode::USD,
                collect([CurrencyCode::GBP, CurrencyCode::JPY, CurrencyCode::EUR])
            )->willReturn(
                [
                    'base' => 'USD',
                    'date' => '2023-05-14',
                    'rates' => [
                        'EUR' => 0.914104,
                        'GBP' => 0.8026,
                        'JPY' => 135.735040,
                    ],
                ]
            );

        $result = $this->service->getLatestExchangeRates();

        $this->assertInstanceOf(CurrencyExchangeRateDto::class, $result);
        $this->assertSame(CurrencyCode::USD, $result->code);

        $rates = $result->rates;

        $this->assertNotEmpty($rates);
        $this->assertSame(3, $rates->count());

        $rate1 = $rates->offsetGet(0);
        $rate2 = $rates->offsetGet(1);
        $rate3 = $rates->offsetGet(2);

        $this->assertSame(CurrencyCode::EUR, $rate1->code);
        $this->assertSame(0.914104, $rate1->rate);
        $this->assertSame(CurrencyCode::GBP, $rate2->code);
        $this->assertSame(0.8026, $rate2->rate);
        $this->assertSame(CurrencyCode::JPY, $rate3->code);
        $this->assertSame(135.735040, $rate3->rate);
    }
}
