<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubscriptionPlanFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement(['Free', 'Starter', 'Professional', 'Business', 'Enterprise']);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'role' => 'employer',
            'price' => match ($name) {
                'Free' => 0,
                'Starter' => 1500,
                'Professional' => 4000,
                'Business' => 9000,
                default => 20000,
            },
            'duration_days' => 30,
            'job_post_limit' => match ($name) {
                'Free' => 1,
                'Starter' => 5,
                'Professional' => 15,
                'Business' => 40,
                default => 999,
            },
            'featured_job_limit' => match ($name) {
                'Free' => 0,
                'Starter' => 1,
                'Professional' => 3,
                'Business' => 10,
                default => 999,
            },
            'cv_access' => $name !== 'Free',
            'description' => fake()->sentence(),
            'features' => ['Priority support', 'Company branding', 'Analytics dashboard'],
            'is_active' => true,
        ];
    }
}
