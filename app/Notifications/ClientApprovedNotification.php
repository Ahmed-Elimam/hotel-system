<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user;
    /**
     * Create a new notification instance.
     */
    public function __construct( $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail' , 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome! Your Account is Approved')
            ->greeting('Congratulations!'.$this->user->name.",")
            ->line('We are pleased to inform you that your account has been approved.')
            ->action('Login Now and make a reservation', url('/login'))
            ->line('Thank you for choosing us!');
        }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'message' => "Dear {$this->user->name}, your account has been approved!",
            'action_url' => url('/login'),
            'created_at' => now(),
        ];
    }
}
