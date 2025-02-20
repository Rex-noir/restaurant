<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'table_id' => \App\Models\Table::factory(),
            'party_size' => fake()->numberBetween(1, 10),
            'status' => \App\enums\ReservationStatusEnum::Pending,
            'date' => fake()->dateTimeBetween('now', '+1 month'),
            'special_requests' => fake()->sentence(),
        ];
    }
}
