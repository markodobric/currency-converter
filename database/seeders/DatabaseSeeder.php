<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Currency::create(['name' => 'US Dollar', 'code' => 'USD']);
        Currency::create(['name' => 'Japanese Yen', 'code' => 'JPY', 'surcharge' => 7.5]);
        Currency::create(['name' => 'British Pound', 'code' => 'GBP', 'surcharge' => 5.0]);
        Currency::create(['name' => 'Euro', 'code' => 'EUR', 'surcharge' => 5.0, 'discount' => 2.0]);
    }
}
