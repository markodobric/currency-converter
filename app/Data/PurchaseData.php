<?php declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

class PurchaseData extends Data
{
    public function __construct(
        public int $from,
        public int $to,
        public string $amount
    ) {}

    public static function rules(): array
    {
        return [
            'from' => ['required', 'exists:currencies,id'],
            'to' => ['required', 'exists:currencies,id'],
            'amount' => ['required', 'regex:/^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/'],
        ];
    }
}
