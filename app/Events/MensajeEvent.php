<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use App\Models\Mensajes;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MensajeEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $mensaje;
    /**
     * Create a new event instance.
     */
    public function __construct($user_id, $mensaje)
    {
        $newMensaje = New Mensajes();
        $newMensaje->user_id = $user_id;
        $newMensaje->mensaje = $mensaje;
        $newMensaje->save();

        $this->mensaje = $mensaje;
        $this->username = User::find($user_id)->name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('our-channel'),
        ];
    }
}
