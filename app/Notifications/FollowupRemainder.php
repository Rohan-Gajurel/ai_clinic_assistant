<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FollowupRemainder extends Notification
{
    use Queueable;

    public $followup;
    public $days;

    /**
     * Create a new notification instance.
     */
    public function __construct($followup, $days=1)
    {
        $this->followup = $followup;
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
        return (new MailMessage)
            ->line("You have a follow-up scheduled in {$this->days} day(s).")
            ->line('Follow-up Details:')
            ->line('Date: '.($this->followup->followup_date ?? 'N/A'))
            ->line('Time: '.($this->followup->followup_time ?? 'N/A'))
            ->line('Notes: '.($this->followup->notes ?? 'N/A'))
            ->action('View Follow-up', url('/'))
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
