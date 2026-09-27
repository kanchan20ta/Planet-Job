<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Central place that decides where a user lands after login,
     * based on their role. Used by RedirectIfAuthenticated middleware
     * and the login controller.
     */
    public static function homeFor(User $user): string
    {
        return match ($user->role) {
            'admin' => '/admin/dashboard',
            'employer' => '/employer/dashboard',
            'jobseeker' => '/jobseeker/dashboard',
            default => '/',
        };
    }
}
