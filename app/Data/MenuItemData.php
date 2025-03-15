<?php

namespace App\Data;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

/** @typescript */
class MenuItemData extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public float $price,
        public ?int $preparationTime,
        public string $slug,
        public bool $isAvailable,
        public ImageData $primaryImage,
        /** @var array<TagData> */
        public Lazy|Collection $tags,
        /** @var array<ImageData> */
        public Lazy|Collection $images
    ) {
    }

    public static function fromModel(MenuItem $model)
    {
        return self::from([
            ...$model->toArray(),
            'images' => Lazy::whenLoaded('images', $model, fn () => ImageData::collect($model->images)),
            'tags' => Lazy::whenLoaded('tags', $model, fn () => TagData::collect($model->tags)),
        ]);
    }
}
