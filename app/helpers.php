<?php

use App\Exceptions\InvalidPhoneNumberException;

function cleanPhoneNumber($phone)
{
    if(!is_string($phone)) {
        throw new InvalidPhoneNumberException();
    }

    $cleanedPhone = preg_replace('/\D/', '', $phone);

    if($cleanedPhone === null) {
        throw new InvalidPhoneNumberException();
    }

    return substr($cleanedPhone, -10);
}