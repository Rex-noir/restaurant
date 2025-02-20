<?php

namespace App\enums;

enum TableStatusEnum: String
{
    case Available = 'available';
    case Unavailable = 'unavailable';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
