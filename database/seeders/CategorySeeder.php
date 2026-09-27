<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'IT', 'Marketing & Sales', 'Accounting & Finance',
            'Human Resources', 'Engineering', 'Healthcare & Medical', 'Education & Training',
            'Customer Service', 'Design & Creative', 'Legal', 'Hospitality & Travel',
            'Construction & Real Estate', 'Manufacturing', 'Telecommunication', 'NGO',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'icon' => 'fa-briefcase', 'is_active' => true]
            );
        }
    }
}
