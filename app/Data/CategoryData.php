<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

/** @typescript */
class CategoryData extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        #[MapOutputName('image')]
        public ?string $imagePath,
        /** @var array<MenuItemData> */
        public ?array $menuItems,
    ) {}
}
