<?php declare(strict_types=1);

namespace App\Service\ApiLayer;

use App\Models\Enum\CurrencyCode;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ApiLayerConnectorService
{
    const APILAYER_API_URL = 'https://api.apilayer.com/exchangerates_data/latest';

    public function __construct(private readonly string $apiKey) {}

    public function __invoke(CurrencyCode $base, Collection $references): Response
    {
        return Http::withHeaders(
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
    }
}
