<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationSuccessful extends Notification
{
    use Queueable;
    // protected $messages;
    /**
     * Create a new notification instance.
     */
    public function __construct($messages)
    {
        $this->messages = $messages;
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
    public function toMail($notifiable): MailMessage
    {
        $mailMessage = new MailMessage;
        $mailMessage->greeting($this->messages['greeting-text'] ?? '');
        $mailMessage->subject($this->messages['subject'] ?? 'Welcome to Welcome to Local Integration Portal');

        foreach ($this->messages['lines_array'] as $key => $value) {
            if (strpos($key, 'special_') === 0) {
                $specialLabel = ucwords(str_replace('_', ' ', str_replace('special_', '', $key)));
                $mailMessage->line($specialLabel . ': ' . $value);
            } else {
                $mailMessage->line($value);
            }
        }

        $mailMessage->action('Login', route('login'));
        $mailMessage->line($this->messages['additional-info'] ?? '');
        $mailMessage->line($this->messages['thanks-message'] ?? '');

        return $mailMessage;
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
