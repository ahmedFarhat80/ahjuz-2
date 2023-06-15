<?php

namespace App\Notifications;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MessageNotification extends Notification
{
    use Queueable;

    public $sender;
    public $message;
    public $property_id;
    public $property_name;

    public function __construct($sender, $message, $property_id = null, $property_name = null)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->property_id = $property_id;
        $this->property_name = $property_name;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }


    public function toArray($notifiable)
    {
        return [
            'customer_id' => $this->sender->id,            
            'name' => $this->sender->name ?? $this->sender->full_name,            
            'property_id' => $this->property_id,            
            'property_name' => $this->property_name,            
            'message' => Str::limit($this->message, 60),            
        ];
    }

    public function broadcastType()
    {
        return 'NewMessage';
    }
}
