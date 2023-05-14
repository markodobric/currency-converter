<?php

namespace App\Providers;

use App\Service\ApiLayer\ApiLayerConnectorService;
use App\Service\ApiLayer\ApiLayerExchangeRateService;
use App\Service\ExchangeRateServiceInterface;
use Illuminate\Container\Container;
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
    }

    public function boot(): void
    {
    }
}
