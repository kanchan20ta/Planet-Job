<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class JobController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $jobs = Job::with('company', 'category')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest()
            ->paginate(20);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function edit(Job $job)
    {
        $this->authorize('update', $job);

        return view('admin.jobs.edit', [
            'job' => $job,
            'categories' => Category::where('is_active', true)->get(),
            'jobTypes' => JobType::all(),
        ]);
    }

    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'job_type_id' => 'required|exists:job_types,id',
            'city' => 'nullable|string|max:255',
            'is_remote' => 'nullable|boolean',
            'experience_level' => 'nullable|string|max:255',
            'vacancy' => 'nullable|integer|min:1',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_type' => 'nullable|string|max:255',
            'description' => 'required|string',
            'responsibilities' => 'nullable|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        $validated['is_remote'] = $request->boolean('is_remote');

        $job->update($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job updated.');
    }

    public function approve(Job $job)
    {
        $this->authorize('approve', $job);

        $job->update(['status' => 'active']);

        return back()->with('success', 'Job approved and published.');
    }

    public function reject(Job $job)
    {
        $this->authorize('approve', $job);

        $job->update(['status' => 'closed']);

        return back()->with('success', 'Job rejected.');
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return back()->with('success', 'Job removed.');
    }
}
