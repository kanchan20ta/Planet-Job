<?php

namespace Database\Factories;

use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-2 months', 'now');

        return [
            'user_id' => User::factory()->employer(),
            'plan_id' => SubscriptionPlan::factory(),
            'starts_at' => $start,
            'ends_at' => (clone $start)->modify('+30 days'),
            'jobs_posted' => fake()->numberBetween(0, 5),
            'featured_jobs_used' => fake()->numberBetween(0, 2),
            'status' => fake()->randomElement(['active', 'expired', 'cancelled']),
        ];
    }
}
