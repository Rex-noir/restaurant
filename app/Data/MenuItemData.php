<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class MenuItemData extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public float $price,
        #[MapOutputName('image')]
        public ?string $imagePath,
        public bool $isAvailable,
    ) {}
}
