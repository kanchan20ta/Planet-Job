<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Full-time', 'Part-time', 'Contract', 'Internship', 'Work from home', 'Freelance'];

        foreach ($types as $name) {
            JobType::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
        }
    }
}
