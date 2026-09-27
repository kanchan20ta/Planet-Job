<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'total_users' => User::count(),
                'total_employers' => User::where('role', 'employer')->count(),
                'total_jobseekers' => User::where('role', 'jobseeker')->count(),
                'total_companies' => Company::count(),
                'total_jobs' => Job::count(),
                'pending_jobs' => Job::where('status', 'pending')->count(),
                'active_jobs' => Job::where('status', 'active')->count(),
                'total_applications' => JobApplication::count(),
                'revenue' => Payment::where('status', 'success')->sum('amount'),
            ],
            // Month-by-month job posting trend for the analytics chart (trailing 12 months)
            'jobsByMonth' => Job::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderByDesc('month')
                ->take(12)
                ->get()
                ->sortBy('month')
                ->values()
                ->map(function ($row) {
                    $row->total = (int) $row->total;
                    return $row;
                }),
            'recentJobs' => Job::with('company')->latest()->take(8)->get(),
            'recentUsers' => User::latest()->take(8)->get(),
        ]);
    }
}
