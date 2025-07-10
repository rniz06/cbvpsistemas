<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Admin\CiudadGral;
use App\Models\Cca\Servicios\Clasificacion;
use App\Models\Cca\Servicios\Servicio;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DespachoPorServicio extends Component
{
    // Propiedades para los select
    public $servicios, $clasificaciones, $ciudades;

    // Propiedades para el formulario
    #[Validate]
    public $servicio_id, $clasificacion_id, $informacion_servicio, $ciudad_id, $calle_referencia;

    public function mount()
    {
        $this->servicios = Servicio::select('id_servicio', 'servicio')->get();
        $this->clasificaciones = Clasificacion::select('id_servicio_clasificacion', 'clasificacion', 'servicio_id')
            ->where('servicio_id', $this->servicio_id)->get();
        $this->ciudades = CiudadGral::select('id_ciudad', 'ciudad')->get();
    }

    public function render()
    {
        return view('livewire.cca.despacho.despacho-por-servicio');
    }
}
