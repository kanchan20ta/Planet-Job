<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        $categories = Category::all();
        $jobTypes = JobType::all();
        $skills = Skill::all();

        if ($companies->isEmpty() || $categories->isEmpty() || $jobTypes->isEmpty()) {
            $this->command?->warn('Run CompanySeeder, CategorySeeder, JobTypeSeeder first.');

            return;
        }

        foreach (range(1, 60) as $i) {
            $company = $companies->random();

            $job = Job::factory()->create([
                'company_id' => $company->id,
                'category_id' => $categories->random()->id,
                'job_type_id' => $jobTypes->random()->id,
                'posted_by' => $company->user_id,
            ]);

            // Attach 3-6 random skills to each job
            $job->skills()->attach(
                $skills->random(min($skills->count(), rand(3, 6)))->pluck('id')->toArray()
            );
        }
    }
}
