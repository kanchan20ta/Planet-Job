<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->employer(),
            'subscription_id' => Subscription::factory(),
            'amount' => fake()->randomElement([1500, 4000, 9000, 20000]),
            'currency' => 'NPR',
            'payment_method' => fake()->randomElement(['esewa', 'khalti', 'stripe', 'bank']),
            'transaction_id' => strtoupper(fake()->unique()->bothify('TXN-########')),
            'status' => fake()->randomElement(['pending', 'success', 'success', 'failed']),
            'meta' => null,
        ];
    }
}
