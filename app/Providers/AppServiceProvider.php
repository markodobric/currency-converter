<?php

namespace App\Providers;

use App\Service\ApiLayer\ApiLayerConnectorService;
use App\Service\ApiLayer\ApiLayerExchangeRateService;
use App\Service\ExchangeRateServiceInterface;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ExchangeRateServiceInterface::class, function (Container $c) {
            return new ApiLayerExchangeRateService(
                new ApiLayerConnectorService(config('services.apylayer.key')),
                $c->get(LoggerInterface::class)
            );
        });
    }

    public function boot(): void
    {
    }
}
