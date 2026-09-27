<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('jobseeker.dashboard', [
            'profile' => $user->jobseekerProfile,
            'recentApplications' => $user->applications()->with('job.company')->latest('applied_at')->take(5)->get(),
            'savedJobs' => $user->savedJobs()->with('job.company')->latest()->take(5)->get(),
            'stats' => [
                'applications' => $user->applications()->count(),
                'shortlisted' => $user->applications()->where('status', 'shortlisted')->count(),
                'saved' => $user->savedJobs()->count(),
            ],
        ]);
    }
}
