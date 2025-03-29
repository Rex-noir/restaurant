<?php

namespace App\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class MenuItemOptionValueData extends Data
{
    public function __construct(
        public string $value,
        public float $price_mod,
    ) {
    }
}
