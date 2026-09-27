<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'user_id' => User::factory()->employer(),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(100, 9999),
            'logo' => null,
            'cover_image' => null,
            'description' => fake()->paragraphs(3, true),
            'industry' => fake()->randomElement(['IT & Software', 'Banking & Finance', 'Education', 'Healthcare', 'Manufacturing', 'Hospitality', 'Telecommunication', 'NGO/INGO']),
            'founded_year' => fake()->numberBetween(1990, 2023),
            'company_size' => fake()->randomElement(['1-10', '11-50', '51-200', '201-500', '501-1000', '1000+']),
            'website' => fake()->url(),
            'email' => fake()->companyEmail(),
            'phone' => fake()->numerify('01-4######'),
            'address' => fake()->streetAddress(),
            'city' => fake()->randomElement(['Kathmandu', 'Lalitpur', 'Bhaktapur', 'Pokhara', 'Biratnagar', 'Butwal']),
            'country' => 'Nepal',
            'is_verified' => fake()->boolean(70),
        ];
    }
}
