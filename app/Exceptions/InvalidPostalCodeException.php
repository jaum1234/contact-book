<?php

namespace App\Exceptions;

class InvalidPostalCodeException extends \Exception
{
    /**
     * Create a new InvalidPostalCodeException instance.
     *
     * @param string $postalCode
     * @return void
     */
    public function __construct(string $postalCode)
    {
        parent::__construct("The postal code '{$postalCode}' is invalid.");
    }
}