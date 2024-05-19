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
    
    public function mount(){
        $mensajes = Mensajes::all();
        foreach($mensajes as $mensaje){
            $this->conver[] = [
                "username" => $mensaje->user->name,
                "mensaje" => $mensaje->mensaje
            ];
        }
    }

    public function submitMensaje() {
        MensajeEvent::dispatch(Auth::user()->id, $this->mensaje);
        $this->mensaje = "";
    }

    #[On('echo:our-channel,MensajeEvent')]
    public function listenForMensaje($data){
        $this->conver[] = [
            "username" => $data['username'],
            "mensaje" => $data['mensaje']
        ];
    }
    public function render()
    {
        return view('livewire.chat-component');
    }
}
