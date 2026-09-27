<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptions)
    {
    }

    public function index()
    {
        $company = Auth::user()->company;

        $jobs = $company->jobs()->withCount('applications')->latest()->take(5)->get();

        return view('employer.dashboard', [
            'company' => $company,
            'jobs' => $jobs,
            'stats' => [
                'total_jobs' => $company->jobs()->count(),
                'active_jobs' => $company->jobs()->where('status', 'active')->count(),
                'total_applications' => \App\Models\JobApplication::whereIn('job_id', $company->jobs()->pluck('id'))->count(),
                'pending_applications' => \App\Models\JobApplication::whereIn('job_id', $company->jobs()->pluck('id'))->where('status', 'pending')->count(),
            ],
            'subscription' => $this->subscriptions->activeSubscription(Auth::user()),
        ]);
    }
}
