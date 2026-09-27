<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Information Technology', 'Marketing & Sales', 'Accounting & Finance',
            'Human Resources', 'Engineering', 'Healthcare & Medical', 'Education & Training',
            'Customer Service', 'Design & Creative', 'Legal', 'Hospitality & Travel',
            'Construction & Real Estate', 'Manufacturing', 'Telecommunication', 'NGO/INGO',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'icon' => 'fa-briefcase',
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
