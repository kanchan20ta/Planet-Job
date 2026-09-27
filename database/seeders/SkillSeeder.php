<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            'PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'MySQL', 'Tailwind CSS',
            'Bootstrap', 'Project Management', 'Digital Marketing', 'SEO', 'Accounting',
            'Excel', 'Communication', 'Graphic Design', 'Python', 'Data Analysis',
            'Customer Support', 'Content Writing', 'Team Leadership',
        ];

        foreach ($skills as $name) {
            Skill::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
        }
    }
}
