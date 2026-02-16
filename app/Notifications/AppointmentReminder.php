<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $appointment;
    public $days;
    public function __construct($appointment, $days = 1)
    {
        //
        $this->appointment = $appointment;
        $this->days = $days;
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
        $date = optional($this->appointment)->appointment_date;
        $time = optional($this->appointment)->start_time ?? optional($this->appointment)->appointment_time ?? '';

        return (new MailMessage)
                    ->line("This is a reminder for your appointment is after $this->days days. Please arrive on time and bring any necessary documents.")
                    ->line('Appointment Details:')
                    ->line('Date: '.($date ?? 'N/A'))
                    ->line('Time: '.($time ?? 'N/A'))
                    ->action('View Appointment', url('/frontend-appointments'))
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
