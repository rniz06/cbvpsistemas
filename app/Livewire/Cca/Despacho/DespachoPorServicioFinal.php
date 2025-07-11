<?php

namespace App\Livewire\Cca\Despacho;

use Livewire\Component;

class DespachoPorServicioFinal extends Component
{
    public $servicio;
    
    public function render()
    {
        return view('livewire.cca.despacho.despacho-por-servicio-final');
    }
}
