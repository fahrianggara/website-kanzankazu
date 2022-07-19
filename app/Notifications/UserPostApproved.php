<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class UserPostApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail'];
        return ['database'];
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
            ->greeting('Haloo, ' . $this->user->name)
            ->line('Postingan kamu sudah disetujui oleh ' . Auth::user()->roles->first()->name . '.')
            ->action('Lihat Postingan', route('posts.index'))
            ->line('Terima kasih sudah berkonstribusi di website kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id' => Auth::user()->id,
            'approvedBy' => Auth::user()->name,
            'title' => 'Postingan Disetujui',
            'message' => 'Postingan kamu telah disetujui oleh ' . Auth::user()->roles->first()->name . '.',
        ];
    }
}
