<?php

namespace Database\Factories;

use App\enums\GenderEnums;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_of_birth' => fake()->date(),
            'gender' => fake()->randomElement(GenderEnums::values()),
            'phone' => fake()->phoneNumber(),
            'user_id' => UserFactory::class
        ];
    }
}
