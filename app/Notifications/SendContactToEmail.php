<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendContactToEmail extends Notification implements ShouldQueue
{
    use Queueable;
    public $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from($this->message['email'])
            ->subject('New Message from ' . $this->message['name'])
            ->greeting('Hello, Angga!')
            ->line('You have a new message from ' . $this->message['name'])
            ->line('Email : ' . $this->message['email'])
            ->line('Subject : ' . $this->message['subject'])
            ->line('Message : ' . $this->message['message']);
    }
}
