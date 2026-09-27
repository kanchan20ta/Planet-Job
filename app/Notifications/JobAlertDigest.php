<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class JobAlertDigest extends Notification
{
    use Queueable;

    /** @param Collection<int, \App\Models\Job> $jobs */
    public function __construct(public Collection $jobs, public string $keyword)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('New jobs matching "' . $this->keyword . '" on Planet Job Portal')
            ->greeting('Hi ' . $notifiable->name . ',')
            ->line('We found ' . $this->jobs->count() . ' new job(s) matching your alert.');

        foreach ($this->jobs->take(5) as $job) {
            $mail->line('• ' . $job->title . ' at ' . $job->company->name);
        }

        return $mail->action('View All Matching Jobs', url('/jobs?keyword=' . urlencode($this->keyword)));
    }
}
