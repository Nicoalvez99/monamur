<?php

namespace App\Livewire;

use App\Models\Mensajes;
use App\Events\MensajeEvent;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class ChatComponent extends Component
{
    public $mensaje;
    public $conver = [];
    public $destinatario;

    public function mount(){
        $mensajes = Mensajes::where('remitente', '=', Auth::user()->id);

        foreach($mensajes as $mensaje){
            $this->conver[] = [
                "destinatario" => $mensaje->destinatario,
                "mensaje" => $mensaje->mensaje
            ];
        }
    }

    public function submitMensaje() {
        MensajeEvent::dispatch(Auth::user()->id, $this->mensaje, $this->destinatario);
        $this->mensaje = "";
    }
    #[On('echo:our-channel,MensajeEvent')]
    public function listenForMensaje($data){
        $this->conver[] = [
            "destinatario" => $data->destinatario,
            "mensaje" => $data->mensaje
        ];
    }
    public function render()
    {
        return view('livewire.chat-component');
    }
}
