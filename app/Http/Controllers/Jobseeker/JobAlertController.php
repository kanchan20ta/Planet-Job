<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobAlert;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobAlertController extends Controller
{
    public function index()
    {
        return view('jobseeker.job-alerts.index', [
            'alerts' => Auth::user()->jobAlerts()->with('category', 'jobType')->latest()->get(),
            'categories' => Category::where('is_active', true)->get(),
            'jobTypes' => JobType::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keyword' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'job_type_id' => ['nullable', 'exists:job_types,id'],
            'location' => ['nullable', 'string', 'max:255'],
            'frequency' => ['required', 'in:instant,daily,weekly'],
        ]);

        JobAlert::create([...$validated, 'user_id' => Auth::id(), 'is_active' => true]);

        return back()->with('success', 'Job alert created.');
    }

    public function destroy(JobAlert $jobAlert)
    {
        abort_unless($jobAlert->user_id === Auth::id(), 403);

        $jobAlert->delete();

        return back()->with('success', 'Job alert removed.');
    }
}
