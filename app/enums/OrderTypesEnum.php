<?php

namespace App\enums;

enum OrderTypesEnum: String
{
    case DELIVERY = 'delivery';

    case DINE_IN = 'dine_in';

    case CATERING = 'catering';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
