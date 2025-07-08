<?php

namespace App\Livewire\Cca\Despacho;

use Livewire\Component;

class DespachoPorCompaniaFinal extends Component
{
    public $compania;
    
    public function render()
    {
        return view('livewire.cca.despacho.despacho-por-compania-final');
    }
}
