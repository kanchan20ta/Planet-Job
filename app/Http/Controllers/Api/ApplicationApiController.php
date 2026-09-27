<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\ApplyJobRequest;
use App\Http\Resources\JobApplicationResource;
use App\Models\Job;
use App\Models\JobApplication;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class ApplicationApiController extends Controller
{
    public function __construct(protected NotificationService $notifications)
    {
    }

    /** GET /api/v1/applications — authenticated jobseeker's own applications. */
    public function index()
    {
        return JobApplicationResource::collection(
            Auth::user()->applications()->with('job.company')->latest('applied_at')->paginate(10)
        );
    }

    /** POST /api/v1/jobs/{job}/apply */
    public function store(ApplyJobRequest $request, Job $job)
    {
        abort_if($job->status !== 'active', 404);

        abort_if(
            $job->applications()->where('user_id', Auth::id())->exists(),
            409,
            'Already applied to this job.'
        );

        $application = JobApplication::create([
            'job_id' => $job->id,
            'user_id' => Auth::id(),
            'cover_letter' => $request->input('cover_letter'),
            'resume_path' => Auth::user()->jobseekerProfile?->resume_path,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $this->notifications->notifyEmployerOfApplication($application);

        return new JobApplicationResource($application->load('job.company'));
    }
}
