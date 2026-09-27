<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_can_browse_active_jobs(): void
    {
        $employer = User::factory()->employer()->create();
        $company = Company::factory()->create(['user_id' => $employer->id]);

        Job::factory()->active()->create([
            'company_id' => $company->id,
            'category_id' => Category::factory(),
            'job_type_id' => JobType::factory(),
            'posted_by' => $employer->id,
            'title' => 'Senior Laravel Developer',
        ]);

        $response = $this->get('/jobs');

        $response->assertOk();
        $response->assertSee('Senior Laravel Developer');
    }

    public function test_draft_jobs_are_not_publicly_visible(): void
    {
        $employer = User::factory()->employer()->create();
        $company = Company::factory()->create(['user_id' => $employer->id]);

        $job = Job::factory()->create([
            'company_id' => $company->id,
            'category_id' => Category::factory(),
            'job_type_id' => JobType::factory(),
            'posted_by' => $employer->id,
            'status' => 'draft',
        ]);

        $this->get('/jobs/'.$job->slug)->assertForbidden();
    }
}
