<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Job;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'featuredJobs' => Job::active()->featured()->with(['company', 'category', 'jobType'])->latest()->take(6)->get(),
            'latestJobs' => Job::active()->with(['company', 'category', 'jobType'])->latest()->take(8)->get(),
            'categories' => Category::where('is_active', true)->withCount(['jobs' => fn ($q) => $q->active()])->take(12)->get(),
            'latestBlogs' => Blog::published()->latest('published_at')->take(3)->get(),
            'stats' => [
                'jobs' => Job::active()->count(),
                'companies' => \App\Models\Company::count(),
                'jobseekers' => \App\Models\User::where('role', 'jobseeker')->count(),
            ],
        ]);
    }
}
