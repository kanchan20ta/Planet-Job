<?php

namespace App\Console\Commands;

use App\Models\Job;
use App\Models\JobAlert;
use App\Notifications\JobAlertDigest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendJobAlerts extends Command
{
    protected $signature = 'jobs:send-alerts {frequency=daily : instant|daily|weekly}';

    protected $description = 'Matches active JobAlerts against newly posted jobs and emails a digest.';

    public function handle(): int
    {
        $frequency = $this->argument('frequency');

        $alerts = JobAlert::where('is_active', true)
            ->where('frequency', $frequency)
            ->with('user', 'category', 'jobType')
            ->get();

        $sent = 0;

        foreach ($alerts as $alert) {
            $since = $alert->last_sent_at ?? now()->subDays(7);

            $matches = Job::active()
                ->with('company')
                ->where('created_at', '>=', $since)
                ->when($alert->keyword, fn ($q) => $q->where('title', 'like', "%{$alert->keyword}%"))
                ->when($alert->category_id, fn ($q) => $q->where('category_id', $alert->category_id))
                ->when($alert->job_type_id, fn ($q) => $q->where('job_type_id', $alert->job_type_id))
                ->when($alert->location, fn ($q) => $q->where('city', 'like', "%{$alert->location}%"))
                ->get();

            if ($matches->isNotEmpty()) {
                $alert->user->notify(new JobAlertDigest($matches, $alert->keyword ?? 'your alert'));
                $alert->update(['last_sent_at' => now()]);
                $sent++;
            }
        }

        $this->info("Sent {$sent} job alert digest(s) for frequency: {$frequency}.");

        return self::SUCCESS;
    }
}
