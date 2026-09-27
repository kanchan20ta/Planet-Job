<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled tasks
|--------------------------------------------------------------------------
| Requires a real cron entry running `php artisan schedule:run` every
| minute on the server (standard Laravel deployment requirement).
*/
Schedule::command('jobs:expire')->daily();
Schedule::command('jobs:send-alerts instant')->everyFifteenMinutes();
Schedule::command('jobs:send-alerts daily')->dailyAt('08:00');
Schedule::command('jobs:send-alerts weekly')->weeklyOn(1, '08:00'); // Monday
