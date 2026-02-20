<?php

use App\Console\Commands\SendMedicationReminders;
use App\Jobs\AppointmentReminder;
use App\Jobs\FollowupRemainder;
use App\Jobs\MedicationReminder;
use App\Jobs\RequestFeedback;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new AppointmentReminder())->daily();

Schedule::job(new FollowupRemainder())->daily();

Schedule::job(new RequestFeedback())->daily();

Schedule::job(new MedicationReminder())->everyMinute();

Schedule::command(SendMedicationReminders::class)->everyMinute();