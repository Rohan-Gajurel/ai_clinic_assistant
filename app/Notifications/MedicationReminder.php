<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MedicationReminder extends Notification
{
    use Queueable;

    public $reminder;

    /**
     * Create a new notification instance.
     */
    public function __construct($reminder)
    {
        $this->reminder = $reminder;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('This is a reminder to take your medication as prescribed.')
            ->line('Please ensure you follow the dosage and timing instructions provided by your healthcare provider.')
            ->line('Medication Details:')
            ->line('Medicine: ' . ($this->reminder->medicine ?? 'N/A'))
            ->line('Dosage: ' . ($this->reminder->dosage ?? 'N/A'))
            ->line('Time: ' . ($this->reminder->reminder_time ?? 'N/A'))
            ->action('View Medication Schedule', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
