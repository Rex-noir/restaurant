<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\LoadRelation;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

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
