<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\BlogCategory; // Adjust the namespace/model name if yours differs

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Career Advice',
            'Job Search Tips',
            'Resume Writing',
            'Interview Preparation',
            'Workplace Culture',
        ];

        foreach ($categories as $name) {
            BlogCategory::updateOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );
        }
    }
}
