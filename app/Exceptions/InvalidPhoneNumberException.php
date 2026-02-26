<?php

namespace App\Exceptions;

use Exception;

class InvalidPhoneNumberException extends Exception
{
    public function __construct()
    {
        return parent::__construct("The given phone number is not a valid phone number. It must be a string");
    }
}