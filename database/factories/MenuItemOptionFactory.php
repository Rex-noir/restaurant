<?php

namespace Database\Factories;

use App\enums\MenuOptionTypesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItemOption>
 */
class MenuItemOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'type' => fake()->randomElement(collect(MenuOptionTypesEnum::cases())->pluck('value')->all()),
            'menu_item_id' => MenuItemFactory::new()
        ];
    }
}
