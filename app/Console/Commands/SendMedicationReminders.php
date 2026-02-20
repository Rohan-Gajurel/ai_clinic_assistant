<?php

namespace App\Console\Commands;

use App\Jobs\MedicationReminder;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendMedicationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';
    protected $description = 'Send medication reminders';
    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check for reminders within the next minute (minute-based dispatch)
        $now = Carbon::now();
        $nextMinute = $now->copy()->addMinute();
        
        // Get reminders that should be sent within this minute
        $reminders = Reminder::whereBetween('reminder_time', [$now, $nextMinute])
            ->where('sent', false)
            ->where('end_date', '>=', $now)
            ->where('status', 'active') // Only active reminders
            ->get();
        
        $this->info("Found " . $reminders->count() . " reminders to dispatch.");
        
        foreach ($reminders as $reminder) {
            // Calculate delay until reminder_time
            $delay = $reminder->reminder_time->diffInSeconds($now, false);
            
            if ($delay > 0) {
                // Dispatch at exact time using delay
                MedicationReminder::dispatch($reminder)->delay($delay);
                $this->info("Queued reminder ID {$reminder->id} to dispatch in {$delay} seconds.");
            } else {
                // If time has passed within this minute, dispatch immediately
                MedicationReminder::dispatch($reminder);
                $this->info("Dispatched reminder ID {$reminder->id} immediately.");
            }
            
            // Mark as sent to avoid duplicate dispatches
            $reminder->update(['sent' => true]);
        }

        $this->info('Reminders dispatched successfully.');
    }
}
