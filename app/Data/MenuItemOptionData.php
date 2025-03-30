<?php

namespace App\Data;

use App\enums\MenuOptionTypesEnum;
use App\Models\MenuItemOption;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

/** @typescript */
class MenuItemOptionData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public MenuOptionTypesEnum $type,
        #[DataCollectionOf(MenuItemOptionValueData::class)]
        public array|Lazy $values
    ) {
    }

    public static function fromModel(MenuItemOption $option)
    {
        return self::from([
            ...$option->toArray(),
            'values' => Lazy::whenLoaded('values', $option, fn () => MenuItemOptionValueData::collect($option->values))
        ]);
    }
}
