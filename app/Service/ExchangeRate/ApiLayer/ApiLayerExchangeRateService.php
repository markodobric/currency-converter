<?php declare(strict_types=1);

namespace App\Service\ExchangeRate\ApiLayer;

use App\Data\CurrencyExchangeRateDto;
use App\Data\RateDto;
use App\Exceptions\UnableToFetchExchangeRateException;
use App\Models\Enum\CurrencyCode;
use App\Service\ExchangeRate\ExchangeRateServiceInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Carbon;
use Psr\Log\LoggerInterface;

class ApiLayerExchangeRateService implements ExchangeRateServiceInterface
{
    public function __construct(
        private ApiLayerConnectorService $apiLayerConnectorService,
        private LoggerInterface $logger
    ) {}

    public function getLatestExchangeRates(): CurrencyExchangeRateDto
    {
        try {
            $response = call_user_func(
                $this->apiLayerConnectorService,
                CurrencyCode::USD,
                collect([CurrencyCode::GBP, CurrencyCode::JPY, CurrencyCode::EUR])
            );

            $rates = [];
            foreach ($response['rates'] as $currency => $rate) {
                $rates[] = new RateDto(CurrencyCode::from($currency), $rate);
            }

            return new CurrencyExchangeRateDto(
                CurrencyCode::from($response['base']),
                Carbon::make($response['date']),
                RateDto::collection($rates)
            );
        } catch (ConnectionException $e) {
            $this->logger->error(
                'ApiLayer connection timeout exeeded.',
                ['error' => $e->getMessage()]
            );

            throw new UnableToFetchExchangeRateException;
        }
    }
}
