<?php

namespace App\Jobs;

use App\Models\Followup;
use App\Notifications\FollowupRemainder as NotificationsFollowupRemainder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FollowupRemainder implements ShouldQueue
{
    use Queueable, SerializesModels, Dispatchable;

    public int $days = 1;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
        $this->days = 2;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $tagetDate = now()->addDays($this->days)->toDateString();

        $followups = Followup::with('appointment.patient.user')
            ->whereDate('followup_date', $tagetDate)
            ->where('status', 'pending')
            ->get();

        if ($followups->isEmpty()) {
            return;
        }

        foreach ($followups as $followup) {
            $patient = $followup->appointment->patient;
            if (! $patient) {
                continue;
            }

            $user = $patient->user;
            if (! $user) {
                continue;
            }

            try{
                $user->notify(new NotificationsFollowupRemainder($followup, $this->days));
            } catch (\Exception $e) {
                // Handle notification failure, e.g., log the error
                Log::error("Failed to send follow-up reminder for Followup ID {$followup->id}: " . $e->getMessage());
            }

        }
    }
}
