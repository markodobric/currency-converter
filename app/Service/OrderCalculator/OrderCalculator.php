<?php declare(strict_types=1);

namespace App\Service\OrderCalculator;

use App\Data\DecimalValue;
use App\Data\OrderValuesDto;
use App\Exceptions\CurrencyExchangeRateDoesNotExistException;
use App\Models\Currency;
use App\Repository\Eloquent\CurrencyExchangeRateRepository;
use App\Service\CurrencyConverter\CurrencyConverterServiceInterface;

class OrderCalculator implements OrderCalculatorInterface
{
    public function __construct(
        private CurrencyExchangeRateRepository $currencyExchangeRateRepository,
        private CurrencyConverterServiceInterface $currencyConverterService
    ) {}

    public function calculate(DecimalValue $amount, Currency $from, Currency $to): OrderValuesDto
    {
        $currencyExchangeRate = $this->currencyExchangeRateRepository->findByBaseReferenceAndDate(
            $from->code,
            $to->code
        );

        if (!$currencyExchangeRate) {
            throw new CurrencyExchangeRateDoesNotExistException;
        }

        $convertedAmount = $this->currencyConverterService->convert($amount, $currencyExchangeRate);
        $total = $convertedAmount->value;

        $surchargeAmount = null;
        $surchargePercentage = null;
        if ($to->hasSurcharge()) {
            $surchargePercentage = $to->surcharge;
            $surchargeAmount = new DecimalValue(
                bcdiv(bcmul($convertedAmount->value, $surchargePercentage), '100', 6)
            );

            $total = bcadd($convertedAmount->value, $surchargeAmount->value, 6);
        }

        $discountAmount = null;
        $discountPercentage = null;
        if ($to->hasDiscount()) {
            $discountPercentage = $to->discount;
            $discountAmount = new DecimalValue(
                bcdiv(bcmul($total, $discountPercentage), '100', 6)
            );

            $total = bcsub($total, $discountAmount->value, 6);
        }

        return new OrderValuesDto(
            convertedAmount: $convertedAmount,
            total: new DecimalValue($total),
            exchangeRate: $currencyExchangeRate->exchange_rate,
            surchargeAmount: $surchargeAmount,
            surchargePercentage: $surchargePercentage,
            discountAmount: $discountAmount,
            discountPercentage: $discountPercentage
        );
    }
}
