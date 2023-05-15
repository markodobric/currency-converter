<?php

declare(strict_types=1);

namespace App\Data;

use LogicException;

class DecimalValue
{
    public function __construct(public readonly string $value = '0.0')
    {
        if (!preg_match("/^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/", $this->value)) {
            throw new LogicException(
                sprintf(
                    'Value %s is not valid decimal value',
                    $this->value
                )
            );
        }
    }
}
