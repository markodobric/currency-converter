<?php

namespace Database\Factories;

use App\Models\Enum\CurrencyCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CurrencyExchangeRate>
 */
class CurrencyExchangeRateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'base' => CurrencyCode::USD,
            'reference' => CurrencyCode::EUR,
            'exchange_rate' => 0.8623,
            'date' => now(),
        ];
    }
}
