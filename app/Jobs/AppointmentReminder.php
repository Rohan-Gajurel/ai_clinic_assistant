<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Notifications\AppointmentReminder as AppointmentReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;

class AppointmentReminder implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;
    /**
     * Number of days before appointment to send reminder.
     * @var int
     */
    public int $days = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(int $days = 1)
    {
        // number of days before appointment to notify
        $this->days = 2;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send reminders for appointments happening in $this->days days
        $targetDate = now()->addDays($this->days)->toDateString();


        $appointments = Appointment::with('patient.user')
            ->whereDate('appointment_date', $targetDate)
            ->where('status', 'approved')
            ->get();

        if ($appointments->isEmpty()) {
            return;
        }

        foreach ($appointments as $appointment) {
            $patient = $appointment->patient;
            if (! $patient) {
                continue;
            }

            $user = $patient->user;
            if (! $user) {
                continue;
            }
            
            try {
                $user->notify(new AppointmentReminderNotification($appointment, $this->days));
            } catch (\Throwable $e) {
                Log::error('AppointmentReminder: failed to notify user '.$user->id.' for appointment '.$appointment->id.': '.$e->getMessage());
            }
        }
    }
}
