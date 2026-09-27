<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public JobApplication $application)
    {
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Update on your application: ' . $this->application->job->title)
            ->greeting('Hi ' . $notifiable->name . ',')
            ->line('Your application for "' . $this->application->job->title . '" is now: ' . ucfirst($this->application->status) . '.')
            ->action('View Application', url('/jobseeker/applications'))
            ->line('Good luck!');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'application_status_updated',
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'status' => $this->application->status,
        ];
    }
}
