<?php

namespace App\Jobs;

use App\Models\Patient;
use App\Models\Reminder;
use App\Notifications\MedicationReminder as NotificationsMedicationReminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class MedicationReminder implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public ?Reminder $reminder = null)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get the reminder from the job data
        $reminder = $this->reminder ?? Reminder::find($this->reminder->id ?? null);

        if (!$reminder) {
            Log::warning("Reminder not found for ID");
            return;
        }

        Log::info("Processing reminder ID {$reminder->id} for Patient ID {$reminder->patient_id} at " . now()->toDateTimeString());

        $user = optional($reminder->patient)->user;

        if (!$user) {
            Log::warning("No user found for Patient ID {$reminder->patient_id}");
            return;
        }

        try {
            $user->notify(new NotificationsMedicationReminder($reminder));
            Log::info("Medication reminder email sent to {$user->email} for Patient ID {$reminder->patient_id} at " . now()->toDateTimeString());
        } catch (\Exception $e) {
            Log::error("Failed to send reminder for Patient ID {$reminder->patient_id}: " . $e->getMessage());
            $this->fail($e);
        }
    }
}


