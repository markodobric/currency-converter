<?php

namespace Database\Factories;

use App\Models\Enum\CurrencyCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'US Dollar',
            'code' => CurrencyCode::USD,
        ];
    }

    public function eur(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Euro',
                'code' => CurrencyCode::EUR,
            ];
        });
    }

    public function surcharge(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'surcharge' => 5.0,
                'discount' => 2.0,
            ];
        });
    }

    public function discount(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'discount' => 2.0,
            ];
        });
    }
}
