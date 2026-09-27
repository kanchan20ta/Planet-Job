<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question' => fake()->sentence() . '?',
            'answer' => fake()->paragraph(),
            'category' => fake()->randomElement(['general', 'employer', 'jobseeker', 'billing']),
            'order' => fake()->numberBetween(1, 50),
            'is_active' => true,
        ];
    }
}
