<?php

namespace App\Data;

use App\Models\MenuItem;
use App\Models\MenuItemOption;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/** @typescript */
class CheckoutData extends Data
{
    public function __construct(
        public int $quantity,
        public float $total,
        public MenuItemData $menu_item,
        /** @var array<CheckoutOption> */
        public Collection $options,
    ) {
        //
    }
    public static function fromArray(array $array): Collection
    {
        $data = collect();

        if (! isset($array['items'])) {
            abort(400, 'Invalid data');
        }

        foreach ($array['items'] as $item) {
            $menuItem = MenuItem::with('primary_image')->where(['id' => $item['menu_item_id']])->first();

            // Initialize total cost at menu item level
            $optionTotal = 0;

            // Map over options and calculate total per option
            $options = isset($item['options']) ? collect($item['options'])->map(function ($option) use (&$optionTotal) {
                $modelOption = MenuItemOption::where('id', $option['id'])->first();

                $values = $modelOption->values->filter(fn ($value) => in_array($value->id, $option['value']));

                $optionTotal += $values->sum('price_mod'); // Accumulate option price modification

                return [
                    'option' => MenuItemOptionData::fromModel($modelOption),
                    'selected_values' => MenuItemOptionValueData::collect($values),
                    'total' => $values->sum('price_mod'),
                ];
            }) : collect();

            // Calculate final total: (item price * quantity) + total of selected option values
            $finalTotal = $menuItem->price * $item['quantity'] + $optionTotal;

            $data->push([
                'quantity' => $item['quantity'],
                'menu_item' => MenuItemData::fromModel($menuItem),
                'options' => $options,
                'total' => $finalTotal,
            ]);
        }


        return $data;
    }

}
/** @typescript */
class CheckoutOption extends Data
{
    public function __construct(
        public MenuItemOptionData $option,
        #[DataCollectionOf(MenuItemOptionValueData::class)]
        public Collection $selected_values,
        public int $total,
    ) {
        //
    }
}
