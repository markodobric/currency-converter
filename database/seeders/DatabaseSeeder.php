<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\CurrencyExchangeRate;
use App\Models\Enum\CurrencyCode;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Currency::create(['name' => 'US Dollar', 'code' => 'USD']);
        Currency::create(['name' => 'Japanese Yen', 'code' => 'JPY', 'surcharge' => 7.5]);
        Currency::create(['name' => 'British Pound', 'code' => 'GBP', 'surcharge' => 5.0]);
        Currency::create(['name' => 'Euro', 'code' => 'EUR', 'surcharge' => 5.0, 'discount' => 2.0]);

        CurrencyExchangeRate::create([
            'base' => CurrencyCode::USD->value,
            'reference' => CurrencyCode::JPY->value,
            'exchange_rate' => 107.17,
            'date' => now()->format('Y-m-d'),
        ]);
        CurrencyExchangeRate::create([
            'base' => CurrencyCode::USD->value,
            'reference' => CurrencyCode::GBP->value,
            'exchange_rate' => 0.711178,
            'date' => now()->format('Y-m-d'),
        ]);
        CurrencyExchangeRate::create([
            'base' => CurrencyCode::USD->value,
            'reference' => CurrencyCode::EUR->value,
            'exchange_rate' => 0.884872,
            'date' => now()->format('Y-m-d'),
        ]);
    }
}
