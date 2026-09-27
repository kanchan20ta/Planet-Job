<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobseekerProfile;
use App\Models\SubscriptionPlan;
use App\Policies\BlogPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\JobApplicationPolicy;
use App\Policies\JobPolicy;
use App\Policies\JobseekerProfilePolicy;
use App\Policies\SubscriptionPlanPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
Schema::defaultStringLength(191);
        // Explicit policy registration (kept alongside auto-discovery for clarity)
        Gate::policy(Job::class, JobPolicy::class);
        Gate::policy(Company::class, CompanyPolicy::class);
        Gate::policy(JobApplication::class, JobApplicationPolicy::class);
        Gate::policy(Blog::class, BlogPolicy::class);
        Gate::policy(SubscriptionPlan::class, SubscriptionPlanPolicy::class);
        Gate::policy(JobseekerProfile::class, JobseekerProfilePolicy::class);

        // Admin bypasses every policy check automatically.
        Gate::before(function ($user, string $ability) {
            return $user->isAdmin() ? true : null;
        });
    }
}
