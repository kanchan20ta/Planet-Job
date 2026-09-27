<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categoryNames = [
            'Career Advice', 'Resume Tips', 'Interview Prep',
            'Workplace Culture', 'Industry News', 'Hiring Trends',
        ];

        foreach ($categoryNames as $name) {
            BlogCategory::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
        }

        $admin = User::where('role', 'admin')->first() ?? User::factory()->admin()->create();
        $categories = BlogCategory::all();

        Blog::factory()->count(15)->create([
            'user_id' => $admin->id,
            'blog_category_id' => fn () => $categories->random()->id,
        ]);
    }
}
