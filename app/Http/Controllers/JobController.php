<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use App\Services\JobSearchService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class JobController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected JobSearchService $jobSearch)
    {
    }

    public function index(Request $request)
    {
        return view('jobs.index', [
            'jobs' => $this->jobSearch->search($request),
            'categories' => Category::where('is_active', true)->get(),
            'jobTypes' => JobType::all(),
            'filters' => $request->only(['keyword', 'category', 'job_type', 'city', 'experience_level', 'remote_only', 'sort']),
        ]);
    }

    public function show(Job $job)
    {
        $this->authorize('view', $job);

        $job->increment('views_count');
        $job->load(['company', 'category', 'jobType', 'skills']);

        $alreadyApplied = auth()->check()
            && $job->applications()->where('user_id', auth()->id())->exists();

        $relatedJobs = Job::active()
            ->where('category_id', $job->category_id)
            ->where('id', '!=', $job->id)
            ->take(4)
            ->get();

        return view('jobs.show', compact('job', 'alreadyApplied', 'relatedJobs'));
    }
}
