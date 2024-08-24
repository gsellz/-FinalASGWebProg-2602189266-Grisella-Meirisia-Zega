<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FriendRequestNotification extends Notification
{
    use Queueable;

    protected $sender;

    /**
     * Create a new notification instance.
     */
    public function __construct($sender)
    {
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database']; // You can also use 'mail', 'broadcast', etc.
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->sender->name} has sent you a friend request.",
            'sender_id' => $this->sender->id,
        ];
    }
}
