<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use App\Models\Mesa;
use Livewire\Component;

class VotacionPublica extends Component
{
    public $mesas;

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected $pollingInterval = 2000; // 2 segundos

    public function render()
    {
        // Obtener todas las mesas con los votos por candidato
        //$this->mesas = Mesa::with('personales')->get();

        // Obtener todas las mesas con los votos por candidato
        $this->mesas = Mesa::with(['personales'])->get(); // Asegúrate de obtener los votos de cada personal

        // Calcular el total de votos por mesa
        foreach ($this->mesas as $mesa) {
            $mesa->votos_totales = $mesa->personales->sum(function ($personal) {
                return $personal->pivot->votos;
            });
        }

        return view('livewire.votacion-publica');
    }
}