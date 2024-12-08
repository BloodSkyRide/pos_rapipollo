<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ResponseAdmin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $mesagge;
    protected $id_user;
    protected $state;

    public function __construct($mesagge, $id_user, $state)
    {
        $this->mesagge = $mesagge;
        $this->id_user = $id_user;
        $this->state = $state;
    }

 
    public function broadcastOn(): Channel
    {
        
          return  new PrivateChannel('user-'.$this->id_user);

    }


    public function broadcastAs()
    {
        return 'responseAdmin';
    }

    public function broadcastWith()
    {   // aqui definimos los datos que seran enviados al frontend
        return [
            
            'message' => $this->mesagge,
            'state' => $this->state,
        ];
    }
}
