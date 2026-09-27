<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobAlert;
use App\Models\JobseekerProfile;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobseekerSeeder extends Seeder
{
    public function run(): void
    {
        // Profile for the fixed demo jobseeker
        $demoJobseeker = User::where('email', 'jobseeker@planetjob.com')->first();

        if ($demoJobseeker && ! $demoJobseeker->jobseekerProfile) {
            JobseekerProfile::factory()->create(['user_id' => $demoJobseeker->id]);
        }

        // 39 more random jobseekers with profiles
        $jobseekers = User::factory()->jobseeker()->count(39)->create();
        $jobseekers->push($demoJobseeker);

        $jobseekers->each(function (User $user) {
            if (! $user->jobseekerProfile) {
                JobseekerProfile::factory()->create(['user_id' => $user->id]);
            }
        });

        $jobs = Job::all();

        if ($jobs->isEmpty()) {
            $this->command?->warn('Run JobSeeder first.');

            return;
        }

        // Applications, saved jobs, alerts for each jobseeker
        foreach ($jobseekers as $user) {
            $appliedJobs = $jobs->random(min($jobs->count(), rand(1, 5)));

            foreach ($appliedJobs as $job) {
                JobApplication::factory()->create([
                    'user_id' => $user->id,
                    'job_id' => $job->id,
                ]);
            }

            $savedJobs = $jobs->random(min($jobs->count(), rand(0, 4)));

            foreach ($savedJobs as $job) {
                SavedJob::factory()->create([
                    'user_id' => $user->id,
                    'job_id' => $job->id,
                ]);
            }

            if (rand(0, 1)) {
                JobAlert::factory()->create(['user_id' => $user->id]);
            }
        }
    }
}
