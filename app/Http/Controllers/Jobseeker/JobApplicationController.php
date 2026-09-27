<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\ApplyJobRequest;
use App\Models\Job;
use App\Models\JobApplication;
use App\Services\FileUploadService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    public function __construct(
        protected FileUploadService $files,
        protected NotificationService $notifications,
    ) {
    }

    public function index()
    {
        $applications = Auth::user()->applications()->with('job.company')->latest('applied_at')->paginate(10);

        return view('jobseeker.applications.index', compact('applications'));
    }

    public function create(Job $job)
    {
        abort_if($job->status !== 'active', 404);

        abort_if(
            $job->applications()->where('user_id', Auth::id())->exists(),
            409,
            'You have already applied to this job.'
        );

        return view('jobseeker.applications.create', [
            'job' => $job->load('company'),
        ]);
    }

    public function store(ApplyJobRequest $request, Job $job)
    {
        abort_if($job->status !== 'active', 404);

        abort_if(
            $job->applications()->where('user_id', Auth::id())->exists(),
            409,
            'You have already applied to this job.'
        );

        $resumePath = Auth::user()->jobseekerProfile?->resume_path;

        if ($request->hasFile('resume')) {
            $resumePath = $this->files->upload($request->file('resume'), 'application-resumes');
        }

        $application = JobApplication::create([
            'job_id' => $job->id,
            'user_id' => Auth::id(),
            'cover_letter' => $request->input('cover_letter'),
            'resume_path' => $resumePath,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $this->notifications->notifyEmployerOfApplication($application);

        return back()->with('success', 'Application submitted successfully.');
    }

    public function withdraw(JobApplication $application)
    {
        $this->authorize('withdraw', $application);

        $application->delete();

        return back()->with('success', 'Application withdrawn.');
    }
}
