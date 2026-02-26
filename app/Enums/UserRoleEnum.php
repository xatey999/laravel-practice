<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
    case SUPPLIER = 'supplier';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
