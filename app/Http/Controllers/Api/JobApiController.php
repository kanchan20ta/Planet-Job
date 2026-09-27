<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Services\JobSearchService;
use Illuminate\Http\Request;

class JobApiController extends Controller
{
    public function __construct(protected JobSearchService $jobSearch)
    {
    }

    /** GET /api/v1/jobs — public, filterable, paginated job listing. */
    public function index(Request $request)
    {
        return JobResource::collection($this->jobSearch->search($request));
    }

    /** GET /api/v1/jobs/{job} — public job detail. */
    public function show(Job $job)
    {
        abort_unless($job->status === 'active', 404);

        return new JobResource($job->load(['company', 'category', 'jobType', 'skills']));
    }
}
