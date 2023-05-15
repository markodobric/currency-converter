<?php declare(strict_types=1);

namespace App\Exceptions;

class CurrencyExchangeRateDoesNotExistException extends BussinesLogicException
{
    public function __construct()
    {
        parent::__construct('Currency exchange rate does not exist.');
    }
}
