<?php

namespace App\Services;

use App\Models\Job;
use App\Models\JobApplication;
use App\Notifications\ApplicationStatusUpdated;
use App\Notifications\NewJobApplication;

class NotificationService
{
    /** Notify the employer that owns $job when a jobseeker applies. */
    public function notifyEmployerOfApplication(JobApplication $application): void
    {
        $application->job->company->user->notify(new NewJobApplication($application));
    }

    /** Notify the applicant when the employer changes their application status. */
    public function notifyApplicantOfStatusChange(JobApplication $application): void
    {
        $application->applicant->notify(new ApplicationStatusUpdated($application));
    }
}
