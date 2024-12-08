<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeEvent implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    // Define el canal en el que se transmitirá el evento
    public function broadcastOn(): Channel
    {
        return new Channel('realtime-channel');  // Aquí defines el canal
    }

    // Opcional: Define el nombre del evento que se escuchará en el frontend
    public function broadcastAs()
    {
        return 'eventNotifications';
    }

    public function broadcastWith()
    {   // aqui definimos los datos que seran enviados al frontend
        return [
            
            'message' => $this->data,
        ];
    }
}