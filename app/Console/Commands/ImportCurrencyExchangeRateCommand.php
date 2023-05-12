<?php declare(strict_types=1);

namespace App\Console\Commands;

use App\Action\ImportCurrencyExchangeRates;
use App\Exceptions\UnableToFetchExchangeRateException;
use Illuminate\Console\Command;

class ImportCurrencyExchangeRateCommand extends Command
{
    protected $signature = 'app:import-currency-exchange-rate';

    protected $description = 'Import exchange rates';

    public function handle(ImportCurrencyExchangeRates $action): void
    {
        try {
            call_user_func($action);

            $this->info('The import was successful.');
        } catch (UnableToFetchExchangeRateException $e) {
            $this->error($e->getMessage());
        }
    }
}
