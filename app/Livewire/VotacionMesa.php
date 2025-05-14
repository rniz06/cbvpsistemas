<?php

namespace App\Livewire;

use App\Models\Mesa;
use Livewire\Component;

class VotacionMesa extends Component
{
    public $mesa;
    public $personales;
    public $cantidad = [];

    public function mount(Mesa $mesa)
    {
        $this->mesa = $mesa;
        $this->personales = $mesa->personales()->get();

        foreach ($this->personales as $personal) {
            $this->cantidad[$personal->idpersonal] = 1;
        }
    }

    public function agregarUno($personalId)
    {
        $this->mesa->increment('votos', 1);
        $pivot = $this->mesa->personales()->where('personal_id', $personalId)->firstOrFail()->pivot;
        $pivot->increment('votos', 1);

        $this->refreshData();
    }

    public function agregarCantidad($personalId)
    {
        $this->validate([
            "cantidad.$personalId" => 'required|integer|min:1',
        ]);

        $this->mesa->increment('votos', $this->cantidad[$personalId]);
        $pivot = $this->mesa->personales()->where('personal_id', $personalId)->firstOrFail()->pivot;
        $pivot->increment('votos', $this->cantidad[$personalId]);

        $this->refreshData();
        $this->cantidad[$personalId] = 1;
    }

    public function refreshData()
    {
        $this->mesa = $this->mesa->fresh();
        $this->personales = $this->mesa->personales()->get();
    }

    public function render()
    {
        return view('livewire.votacion-mesa');
    }
}
