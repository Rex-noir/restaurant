<?php

namespace Database\Factories;

use App\enums\TableStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Table>
 */
class TableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'capacity' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(TableStatusEnum::values()),
            'location' => fake()->randomElement(['indoor', 'outdoor', 'patio', 'balcony']),
        ];
    }
}
