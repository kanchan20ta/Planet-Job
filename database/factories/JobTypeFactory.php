<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobTypeFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Full-time', 'Part-time', 'Contract', 'Internship', 'Remote', 'Freelance',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
