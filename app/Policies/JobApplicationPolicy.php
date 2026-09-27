<?php

namespace App\Policies;

use App\Models\JobApplication;
use App\Models\User;

class JobApplicationPolicy
{
    /** Only the applicant themself, the hiring employer, or an admin may view an application. */
    public function view(User $user, JobApplication $application): bool
    {
        return $user->isAdmin()
            || $application->user_id === $user->id
            || $application->job->company->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isJobseeker();
    }

    /** Only the employer who owns the job (or admin) can change an application's status. */
    public function updateStatus(User $user, JobApplication $application): bool
    {
        return $user->isAdmin() || $application->job->company->user_id === $user->id;
    }

    /** A jobseeker may withdraw their own application while it's still pending. */
    public function withdraw(User $user, JobApplication $application): bool
    {
        return $application->user_id === $user->id && $application->status === 'pending';
    }
}
