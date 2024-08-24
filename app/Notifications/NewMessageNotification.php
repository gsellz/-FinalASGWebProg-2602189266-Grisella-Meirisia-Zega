<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;

    protected $sender;
    protected $messageContent;

    public function __construct($sender, $messageContent)
    {
        $this->sender = $sender;
        $this->messageContent = $messageContent;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "New message from {$this->sender->name}",
            'message_content' => $this->messageContent,
            'sender_id' => $this->sender->id,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "New message from {$this->sender->name}",
            'message_content' => $this->messageContent,
            'sender_id' => $this->sender->id,
        ];
    }
}
