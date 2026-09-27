<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobAlertFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->jobseeker(),
            'keyword' => fake()->jobTitle(),
            'category_id' => Category::factory(),
            'job_type_id' => JobType::factory(),
            'location' => fake()->randomElement(['Kathmandu', 'Pokhara', 'Lalitpur']),
            'frequency' => fake()->randomElement(['instant', 'daily', 'weekly']),
            'is_active' => true,
            'last_sent_at' => null,
        ];
    }
}
