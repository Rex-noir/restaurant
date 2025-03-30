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

    public function selectType()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => MenuOptionTypesEnum::SELECT->value
            ];
        });
    }

    public function radioType()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => MenuOptionTypesEnum::RADIO->value
            ];
        });
    }

    public function checkboxType()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => MenuOptionTypesEnum::CHECKBOX->value
            ];
        });
    }
}
