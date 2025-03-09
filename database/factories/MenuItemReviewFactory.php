<?php

namespace Database\Factories;

use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItemReview>
 */
class MenuItemReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'menu_item_id' => MenuItem::factory(),
            'user_id' => User::factory(),
            'stars' => rand(1, 5),
            'review_text' => $this->faker->sentence,
        ];
    }
}
