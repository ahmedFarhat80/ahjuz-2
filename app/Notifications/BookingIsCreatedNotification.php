<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingIsCreatedNotification extends Notification
{
    use Queueable;
    
    public $property;

    public function __construct($property)
    {
        $this->property = $property;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'property_id' => $this->property->id,
        ];
    }

    public function broadcastType()
    {
        return 'BookingIsCreated';
    }
}
