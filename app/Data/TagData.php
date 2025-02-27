<?php

namespace App\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class TagData extends Data
{
    public function __construct(
        public string $name,
    ) {}
}
