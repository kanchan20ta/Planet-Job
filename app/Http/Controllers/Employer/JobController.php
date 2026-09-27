<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\StoreJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Skill;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class JobController extends Controller implements HasMiddleware
{use AuthorizesRequests; 
    public function __construct(protected SubscriptionService $subscriptions)
    {
    }

    /** Require an authenticated user with a company profile for every action on this controller. */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('employer.has-company'),
        ];
    }

    public function index()
    {
        $jobs = Auth::user()->company->jobs()->withCount('applications')->latest()->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $this->authorize('create', Job::class);

        if (! $this->subscriptions->canPostJob(Auth::user())) {
            return redirect()->route('employer.subscription.index')
                ->with('error', 'You have reached your job posting limit. Please upgrade your plan.');
        }

        return view('employer.jobs.create', [
            'categories' => Category::where('is_active', true)->get(),
            'jobTypes' => JobType::all(),
            'skills' => Skill::all(),
        ]);
    }

    public function store(StoreJobRequest $request)
    {
        $company = Auth::user()->company;
        $subscription = $this->subscriptions->activeSubscription(Auth::user());

        $wantsFeatured = $request->boolean('is_featured') && $this->subscriptions->canFeatureJob(Auth::user());

        $job = Job::create([
            ...$request->safe()->except(['skills', 'is_featured']),
            'company_id' => $company->id,
            'posted_by' => Auth::id(),
            'slug' => Str::slug($request->title) . '-' . random_int(1000, 99999),
            'is_remote' => $request->boolean('is_remote'),
            'is_featured' => $wantsFeatured,
            'status' => 'pending', // goes live after admin approval
        ]);

        $job->skills()->sync($request->input('skills', []));

        $this->subscriptions->recordJobPosted($subscription, $wantsFeatured);

        return redirect()->route('employer.jobs.index')->with('success', 'Job submitted for approval.');
    }

    public function show(Job $job)
    {
        $this->authorize('view', $job);

        return view('employer.jobs.show', [
            'job' => $job->loadCount('applications')->load('skills'),
        ]);
    }

    public function edit(Job $job)
    {
        $this->authorize('update', $job);

        return view('employer.jobs.edit', [
            'job' => $job->load('skills'),
            'categories' => Category::where('is_active', true)->get(),
            'jobTypes' => JobType::all(),
            'skills' => Skill::all(),
        ]);
    }

    public function update(UpdateJobRequest $request, Job $job)
    {
        $job->update([
            ...$request->safe()->except(['skills', 'is_featured']),
            'is_remote' => $request->boolean('is_remote'),
        ]);

        $job->skills()->sync($request->input('skills', []));

        return redirect()->route('employer.jobs.index')->with('success', 'Job updated.');
    }

    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);

        $job->delete(); // soft delete

        return back()->with('success', 'Job removed.');
    }

    /** Extend an expired/closing job by 30 days and reactivate it (re-enters admin review). */
    public function renew(Job $job)
    {
        $this->authorize('update', $job);

        if (! $this->subscriptions->canPostJob(Auth::user())) {
            return back()->with('error', 'You have reached your job posting limit. Please upgrade your plan to renew.');
        }

        $job->update([
            'deadline' => now()->addDays(30),
            'status' => 'pending',
        ]);

        $subscription = $this->subscriptions->activeSubscription(Auth::user());
        $this->subscriptions->recordJobPosted($subscription);

        return back()->with('success', 'Job renewed for 30 more days and resubmitted for approval.');
    }
}
