<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'user_id' => User::factory()->jobseeker(),
            'rating' => fake()->numberBetween(1, 5),
            'review' => fake()->paragraph(),
            'is_approved' => fake()->boolean(80),
        ];
    }
}
