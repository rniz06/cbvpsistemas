<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Vistas\Cca\VtExistente;
use Livewire\Component;

class VerServicio extends Component
{
    public $servicio;

    public function mount(VtExistente $servicio)
    {
        $this->servicio = $servicio;
    }

    public function render()
    {
        return view('livewire.cca.despacho.ver-servicio');
    }
}
