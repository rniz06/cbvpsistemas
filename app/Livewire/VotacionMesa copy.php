<?php

namespace App\Livewire;

use App\Models\Mesa;
use Livewire\Component;

class VotacionMesa extends Component
{
    public $mesa;
    public $cantidad = 1;

    public function mount(Mesa $mesa)
    {
        $this->mesa = $mesa;
    }

    public function agregarUno()
    {
        $this->mesa->increment('votos');
        $this->mesa->refresh();
    }

    public function agregarCantidad()
    {
        $this->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $this->mesa->increment('votos', $this->cantidad);
        $this->mesa->refresh();
        $this->cantidad = 1;
    }


    public function render()
    {
        return view('livewire.votacion-mesa');
    }
}
