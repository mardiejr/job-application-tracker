<?php

namespace App\Console\Commands;

use App\Models\JobApplication;
use App\Notifications\InterviewReminder;
use Illuminate\Console\Command;

class SendInterviewReminders extends Command
{
    protected $signature = 'app:send-interview-reminders';
    protected $description = 'Notify users about interviews happening in the next 24 hours';

    public function handle(): void
    {
        $applications = JobApplication::whereNotNull('interview_date')
            ->whereBetween('interview_date', [now(), now()->addHours(24)])
            ->with('user')
            ->get();

        $sentCount = 0;

        foreach ($applications as $application) {
            $alreadyNotified = $application->user->notifications()
                ->where('data->application_id', $application->id)
                ->exists();

            if (!$alreadyNotified) {
                $application->user->notify(new InterviewReminder($application));
                $sentCount++;
            }
        }

        $this->info("Sent {$sentCount} interview reminder(s).");
    }
}
