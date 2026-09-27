<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'user_id' => User::factory()->admin(),
            'blog_category_id' => BlogCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(100, 9999),
            'thumbnail' => null,
            'excerpt' => fake()->sentence(20),
            'content' => fake()->paragraphs(8, true),
            'status' => fake()->randomElement(['draft', 'published', 'published']),
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'views' => fake()->numberBetween(0, 5000),
        ];
    }
}
