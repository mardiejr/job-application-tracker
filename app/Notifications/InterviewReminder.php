<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InterviewReminder extends Notification
{
    use Queueable;

    protected JobApplication $application;

    public function __construct(JobApplication $application)
    {
        $this->application = $application;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'company' => $this->application->company->name,
            'position' => $this->application->position,
            'interview_date' => $this->application->interview_date,
        ];
    }
}
