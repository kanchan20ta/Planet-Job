<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SkillFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'MySQL', 'Tailwind CSS',
            'Bootstrap', 'Project Management', 'Digital Marketing', 'SEO', 'Accounting',
            'Excel', 'Communication', 'Graphic Design', 'Python', 'Data Analysis',
            'Customer Support', 'Content Writing', 'Team Leadership',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
