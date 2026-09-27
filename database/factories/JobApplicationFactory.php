<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'job_id' => Job::factory(),
            'user_id' => User::factory()->jobseeker(),
            'cover_letter' => fake()->paragraph(),
            'resume_path' => null,
            'status' => fake()->randomElement(['pending', 'reviewed', 'shortlisted', 'interview', 'rejected', 'hired']),
            'employer_note' => null,
            'applied_at' => fake()->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
