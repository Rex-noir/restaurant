<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => \App\Models\Category::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(100, 1000),
            'is_available' => fake()->boolean(),
            'preparation_time' => fake()->numberBetween(10, 60),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\MenuItem $menuItem) {
            $menuItem->tags()->createMany([
                ['name' => fake()->word()],
                ['name' => fake()->word()],
                ['name' => fake()->word()],
            ]);

            $menuItem->primary_image()->create(Image::factory()->make()->toArray());
            $menuItem->images()->createMany(Image::factory()->count(3)->make()->toArray());
        });
    }
}
