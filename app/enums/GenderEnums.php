<?php

namespace App\enums;

enum GenderEnums: String
{
    case Male = 'male';
    case Female = 'female';
    case Other = 'other';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function options()
    {
        return array_combine(
            array_map(fn(GenderEnums $case) => $case->value, self::cases()),
            array_map(fn(GenderEnums $case) => $case->name, self::cases())
        );
    }
}
