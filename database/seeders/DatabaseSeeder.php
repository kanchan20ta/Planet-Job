<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Master seeder for Planet Job Portal.
     * Run with: php artisan db:seed
     */
    public function run(): void
    {
        // Structural / content data needed in every environment, including
        // production (categories, job types, skills, pricing, static pages).
        $this->call([
            CategorySeeder::class,        // job categories
            JobTypeSeeder::class,         // full-time, part-time, etc.
            SkillSeeder::class,           // master skill list
            SubscriptionPlanSeeder::class, // pricing tiers
            BlogSeeder::class,            // blog categories + posts
            FaqSeeder::class,
            PageSeeder::class,            // About / Privacy / Terms
        ]);

        // Demo/fixture data only: fixed test accounts, sample companies,
        // sample job listings, and sample jobseeker profiles/applications.
        // Never seed this in production.
        if (app()->environment(['local', 'staging'])) {
            $this->call([
                RoleUserSeeder::class,        // admin, employer, jobseeker fixed accounts
                CompanySeeder::class,         // employer companies (+ more employer users)
                JobSeeder::class,             // job listings tied to companies
                JobseekerSeeder::class,       // jobseeker profiles + applications + saved jobs + alerts
            ]);
        }
    }
}
