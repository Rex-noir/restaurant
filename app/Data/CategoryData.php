<?php

namespace App\Data;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

/** @typescript */
class CategoryData extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?string $image,
    ) {
    }
}
