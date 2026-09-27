<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            ['name' => 'Free', 'price' => 0, 'job_post_limit' => 1, 'featured_job_limit' => 0, 'cv_access' => false],
            ['name' => 'Starter', 'price' => 1500, 'job_post_limit' => 5, 'featured_job_limit' => 1, 'cv_access' => true],
            ['name' => 'Professional', 'price' => 4000, 'job_post_limit' => 15, 'featured_job_limit' => 3, 'cv_access' => true],
            ['name' => 'Business', 'price' => 9000, 'job_post_limit' => 40, 'featured_job_limit' => 10, 'cv_access' => true],
            ['name' => 'Enterprise', 'price' => 20000, 'job_post_limit' => 999, 'featured_job_limit' => 999, 'cv_access' => true],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => Str::slug($plan['name'])],
                [
                    'name' => $plan['name'],
                    'role' => 'employer',
                    'type' => 'latest',
                    'price' => $plan['price'],
                    'duration_days' => 30,
                    'job_post_limit' => $plan['job_post_limit'],
                    'featured_job_limit' => $plan['featured_job_limit'],
                    'cv_access' => $plan['cv_access'],
                    'description' => $plan['name'] . ' plan for employers on Planet Job Portal.',
                    'features' => ['Priority support', 'Company branding', 'Analytics dashboard'],
                    'is_active' => true,
                ]
            );
        }
    }
}
