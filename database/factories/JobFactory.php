<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->jobTitle();
        $salaryMin = fake()->numberBetween(20000, 80000);

        return [
            'company_id' => Company::factory(),
            'category_id' => Category::factory(),
            'job_type_id' => JobType::factory(),
            'posted_by' => function (array $attributes) {
                return \App\Models\Company::find($attributes['company_id'])?->user_id
                    ?? \App\Models\User::factory()->employer();
            },
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 99999),
            'description' => fake()->paragraphs(4, true),
            'responsibilities' => implode("\n", fake()->sentences(6)),
            'requirements' => implode("\n", fake()->sentences(6)),
            'benefits' => implode("\n", fake()->sentences(4)),
            'vacancy' => fake()->numberBetween(1, 5),
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMin + fake()->numberBetween(5000, 40000),
            'salary_type' => fake()->randomElement(['monthly', 'yearly', 'negotiable']),
            'experience_level' => fake()->randomElement(['entry', 'mid', 'senior', 'lead', 'executive']),
            'education_level' => fake()->randomElement(["Bachelor's Degree", "Master's Degree", 'Diploma', '+2 / Intermediate']),
            'location' => fake()->randomElement(['Kathmandu', 'Lalitpur', 'Pokhara', 'Biratnagar', 'Butwal']),
            'city' => fake()->randomElement(['Kathmandu', 'Lalitpur', 'Pokhara', 'Biratnagar', 'Butwal']),
            'country' => 'Nepal',
            'is_remote' => fake()->boolean(20),
            'deadline' => fake()->dateTimeBetween('+1 week', '+2 months'),
            'status' => fake()->randomElement(['active', 'active', 'active', 'pending', 'closed']),
            'is_featured' => fake()->boolean(25),
            'views_count' => fake()->numberBetween(0, 2000),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['status' => 'active']);
    }

    public function featured(): static
    {
        return $this->state(fn () => ['status' => 'active', 'is_featured' => true]);
    }
}
