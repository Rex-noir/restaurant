<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItemOptionValue>
 */
class MenuItemOptionValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'menu_item_option_id' => MenuItemOptionFactory::new(),
            'value' => fake()->word(),
            'price_mod' => fake()->randomFloat(2, 0, 100),
            'is_default' => fake()->boolean()
        ];
    }
}
