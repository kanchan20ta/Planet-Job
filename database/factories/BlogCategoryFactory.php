<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Career Advice', 'Resume Tips', 'Interview Prep', 'Workplace Culture',
            'Industry News', 'Hiring Trends',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
