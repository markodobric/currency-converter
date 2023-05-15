<?php declare(strict_types=1);

namespace App\Service\ExchangeRate\ApiLayer;

use App\Exceptions\UnableToFetchExchangeRateException;
use App\Models\Enum\CurrencyCode;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ApiLayerConnectorService
{
    const APILAYER_API_URL = 'https://api.apilayer.com/exchangerates_data/latest';

    public function __construct(private readonly string $apiKey) {}

    public function __invoke(CurrencyCode $base, Collection $references): array
    {
        $response = Http::withHeaders(
                [
                    'Content-Type' => 'application/json',
                    'apikey' => $this->apiKey,
                ]
            )->get(
                self::APILAYER_API_URL,
                [
                    'base' => $base->value,
                    'symbols' => implode(
                        ',',
                        $references
                            ->map(fn(CurrencyCode $code) => $code->value)
                            ->toArray()
                    ),
                ]
            );

        if (!$response->successful()) {
            throw new UnableToFetchExchangeRateException;
        }

        return $response->json();
    }
}
