<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobApplication extends Notification
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
            ->subject('New Application for ' . $this->application->job->title)
            ->greeting('Hi ' . $notifiable->name . ',')
            ->line($this->application->applicant->name . ' just applied for "' . $this->application->job->title . '".')
            ->action('Review Application', url('/employer/jobs/' . $this->application->job_id . '/applications'))
            ->line('Thanks for using Planet Job Portal.');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'new_application',
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_id,
            'job_title' => $this->application->job->title,
            'applicant_name' => $this->application->applicant->name,
        ];
    }
}
