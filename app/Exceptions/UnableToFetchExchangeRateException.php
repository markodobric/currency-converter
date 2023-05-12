<?php

declare(strict_types=1);

namespace App\Exceptions;

class UnableToFetchExchangeRateException extends BussinesLogicException
{
    public function __construct()
    {
        parent::__construct('Unable to fetch exchange rates from 3rd party service.');
    }
}
