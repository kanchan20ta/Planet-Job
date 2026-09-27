<?php

namespace App\Console\Commands;

use App\Models\Job;
use Illuminate\Console\Command;

class ExpireJobs extends Command
{
    protected $signature = 'jobs:expire';

    protected $description = 'Marks active jobs whose deadline has passed as expired.';

    public function handle(): int
    {
        $count = Job::where('status', 'active')
            ->whereNotNull('deadline')
            ->where('deadline', '<', now())
            ->update(['status' => 'expired']);

        $this->info("Marked {$count} job(s) as expired.");

        return self::SUCCESS;
    }
}
