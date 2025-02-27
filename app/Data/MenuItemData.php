<?php

namespace App\Data;

use App\Data\Transformers\PublicUrlTransformer;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

/** @typescript */
class MenuItemData extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public float $price,
        #[WithTransformer(PublicUrlTransformer::class)]
        #[MapOutputName('image')]
        public ?string $imagePath,
        public bool $isAvailable,
        /** @var array<TagData> */
        public ?array $tags,
    ) {
        info($this->imagePath);
    }
}
