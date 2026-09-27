<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_jobseeker_cannot_access_employer_dashboard(): void
    {
        $jobseeker = User::factory()->jobseeker()->create();

        $this->actingAs($jobseeker)
            ->get('/employer/dashboard')
            ->assertForbidden();
    }

    public function test_employer_cannot_access_admin_dashboard(): void
    {
        $employer = User::factory()->employer()->create();

        $this->actingAs($employer)
            ->get('/admin/dashboard')
            ->assertForbidden();
    }

    public function test_admin_can_access_all_dashboards(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/admin/dashboard')->assertOk();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/jobseeker/dashboard')->assertRedirect('/login');
    }
}
