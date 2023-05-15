<?php declare(strict_types=1);

namespace App\Providers;

use App\Service\CurrencyConverter\CurrencyConverterService;
use App\Service\CurrencyConverter\CurrencyConverterServiceInterface;
use App\Service\ExchangeRate\ApiLayer\ApiLayerConnectorService;
use App\Service\ExchangeRate\ApiLayer\ApiLayerExchangeRateService;
use App\Service\ExchangeRate\ExchangeRateServiceInterface;
use App\Service\OrderCalculator\OrderCalculator;
use App\Service\OrderCalculator\OrderCalculatorInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ApiLayerConnectorService::class, function () {
            return new ApiLayerConnectorService(config('services.apylayer.key'));
        });

        $this->app->bind(ExchangeRateServiceInterface::class, function (Application $app) {
            return new ApiLayerExchangeRateService(
                $app->make(ApiLayerConnectorService::class),
                $app->make(LoggerInterface::class)
            );
        });

        $this->app->bind(CurrencyConverterServiceInterface::class, CurrencyConverterService::class);
        $this->app->bind(OrderCalculatorInterface::class, OrderCalculator::class);
    }

    public function boot(): void
    {
    }
}
