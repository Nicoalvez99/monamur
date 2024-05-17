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

    public $remitente;
    public $mensaje;
    public $destinatario;
    /**
     * Create a new event instance.
     */
    public function __construct($remitente, $mensaje, $destinatario)
    {
        $newMensaje = New Mensajes();
        $newMensaje->remitente = $remitente;
        $newMensaje->mensaje = $mensaje;
        $newMensaje->destinatario = $destinatario;
        $newMensaje->save();

        $this->remitente = $remitente;
        $this->mensaje = $mensaje;
        $this->destinatario = User::find($destinatario)->name;
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
