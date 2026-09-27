<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function __construct(protected NotificationService $notifications)
    {
    }

    public function index(Job $job)
    {
        $this->authorize('viewApplications', $job);

        $applications = $job->applications()->with('applicant.jobseekerProfile')->latest('applied_at')->paginate(15);

        return view('employer.applications.index', compact('job', 'applications'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $this->authorize('updateStatus', $application);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,reviewed,shortlisted,interview,rejected,hired'],
            'employer_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $application->update($validated);

        $this->notifications->notifyApplicantOfStatusChange($application);

        return back()->with('success', 'Application status updated.');
    }
}
