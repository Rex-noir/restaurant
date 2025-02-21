<?php

namespace Database\Factories;

use App\enums\OrderStatusEnum;
use App\enums\OrderTypesEnum;
use App\enums\PaymentMethodsEnum;
use App\enums\PaymentStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_type' => fake()->randomElement(OrderTypesEnum::values()),
            'status' => fake()->randomElement(OrderStatusEnum::values()),
            'total_amount' => fake()->numberBetween(100, 1000),
            'payment_status' => fake()->randomElement(PaymentStatusEnum::values()),
            'payment_method' => fake()->randomElement(PaymentMethodsEnum::values()),
            'notes' => fake()->text(),
        ];
    }
}
