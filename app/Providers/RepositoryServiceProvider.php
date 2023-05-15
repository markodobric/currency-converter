<?php declare(strict_types=1);

namespace App\Providers;

use App\Repository\CurrencyExchangeRateRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\CurrencyExchangeRateRepository;
use App\Repository\RepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            RepositoryInterface::class,
            BaseRepository::class
        );
        $this->app->bind(
            CurrencyExchangeRateRepositoryInterface::class,
            CurrencyExchangeRateRepository::class
        );
    }

    public function boot(): void
    {
    }
}
