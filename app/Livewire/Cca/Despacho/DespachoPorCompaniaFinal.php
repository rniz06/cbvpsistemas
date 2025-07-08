<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Vistas\GralVtCompania;
use Livewire\Component;

class DespachoPorCompaniaFinal extends Component
{
    public $compania;

    // Propiedades para los select de las vistas
    public $servicios, $clasificaciones, $ciudades , $moviles;

    // Propiedades para el formulario
    public $servicio_id, $clasificacion_id, $informacion_servicio, $ciudad_id, $calle_referencia, $movil_id, $acargo, $chofer, $cantidad_tripulantes;

    public function mount(GralVtCompania $compania)
    {
        $this->compania = $compania;
        //$this->servicios = $compania;
    }

    public function render()
    {
        return view('livewire.cca.despacho.despacho-por-compania-final');
    }
}
