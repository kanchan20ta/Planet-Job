<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobseekerProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->jobseeker(),
            'headline' => fake()->jobTitle(),
            'bio' => fake()->paragraph(),
            'resume_path' => null,
            'experience_level' => fake()->randomElement(['entry', 'mid', 'senior', 'lead', 'executive']),
            'experience_years' => fake()->numberBetween(0, 15),
            'current_salary' => fake()->numberBetween(20000, 150000),
            'expected_salary' => fake()->numberBetween(25000, 200000),
            'date_of_birth' => fake()->dateTimeBetween('-45 years', '-20 years'),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'address' => fake()->streetAddress(),
            'city' => fake()->randomElement(['Kathmandu', 'Lalitpur', 'Bhaktapur', 'Pokhara', 'Biratnagar']),
            'country' => 'Nepal',
            'is_available' => fake()->boolean(80),
            'profile_public' => true,
        ];
    }
}
