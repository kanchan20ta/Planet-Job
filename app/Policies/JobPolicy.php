<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    /** Anyone can view an active job listing publicly (handled in controller/route, not here). */
    public function view(?User $user, Job $job): bool
    {
        if ($job->status === 'active') {
            return true;
        }

        // Draft/pending/closed jobs are only visible to their owner or an admin
        if (! $user) {
            return false;
        }

        return $user->isAdmin() || $job->company->user_id === $user->id;
    }

    /** Only employers (with an active subscription, checked in the request/controller) may create jobs. */
    public function create(User $user): bool
    {
        return $user->isEmployer();
    }

    public function update(User $user, Job $job): bool
    {
        return $user->isAdmin() || $job->company->user_id === $user->id;
    }

    public function delete(User $user, Job $job): bool
    {
        return $user->isAdmin() || $job->company->user_id === $user->id;
    }

    /** Only the admin can approve a pending job before it goes live. */
    public function approve(User $user, Job $job): bool
    {
        return $user->isAdmin();
    }

    /** Only the owning employer can view the applicant list for a job. */
    public function viewApplications(User $user, Job $job): bool
    {
        return $user->isAdmin() || $job->company->user_id === $user->id;
    }
}
