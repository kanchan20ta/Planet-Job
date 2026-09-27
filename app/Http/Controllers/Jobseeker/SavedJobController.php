<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\SavedJob;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    public function index()
    {
        $savedJobs = Auth::user()->savedJobs()->with('job.company', 'job.category', 'job.jobType')->latest()->paginate(10);

        return view('jobseeker.saved-jobs.index', compact('savedJobs'));
    }

    public function store(Job $job)
    {
        SavedJob::firstOrCreate(['user_id' => Auth::id(), 'job_id' => $job->id]);

        return back()->with('success', 'Job saved.');
    }

    public function destroy(Job $job)
    {
        SavedJob::where('user_id', Auth::id())->where('job_id', $job->id)->delete();

        return back()->with('success', 'Removed from saved jobs.');
    }
}
