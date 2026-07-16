<?php

namespace App\Livewire\Cca\Reportes;

use Livewire\Component;

class ReportePersonalizado extends Component
{
    # COLUMNAS
    public array $columnasDisponibles = [];
    public array $columnasSeleccionadas = [];

    public string $fecha_alfa_desde, $fecha_alfa_hasta;

    public function mount()
    {
        $this->columnasDisponibles = [
            ['campo' => 'informacion_servicio', 'label' => 'Información del Servicio'],
            ['campo' => 'calle_referencia', 'label' => 'Calle de Referencia'],
            ['campo' => 'cantidad_tripulantes', 'label' => 'Cantidad de tripulantes'],
            ['campo' => 'compania_id', 'label' => 'Compañia'],
            ['campo' => 'servicio_id', 'label' => 'Servicio'],
            ['campo' => 'clasificacion_id', 'label' => 'Clasificación'],
            ['campo' => 'ciudad_id', 'label' => 'Ciudad'],
            ['campo' => 'movil_id', 'label' => 'Movil'],
            ['campo' => 'acargo', 'label' => 'A cargo'],
            ['campo' => 'chofer', 'label' => 'Chofer'],
            ['campo' => 'km_final', 'label' => 'Kilometraje Final'],
            ['campo' => 'desperfecto', 'label' => 'Desperfecto Kilometraje Final'],
            ['campo' => 'fecha_alfa', 'label' => 'Fecha Hora Denuncia'],
            ['campo' => 'fecha_cia', 'label' => 'Despacho Compañia'],
            ['campo' => 'fecha_movil', 'label' => 'Salida de móvil'],
            ['campo' => 'fecha_servicio', 'label' => 'Llegada de móvil'],
            ['campo' => 'fecha_base', 'label' => 'Móvil en base'],
            ['campo' => 'falsa_alarma', 'label' => 'Falsa Alarma'],
            ['campo' => 'despacho_policia', 'label' => 'Despacho Policia 911'],
            ['campo' => 'creadoPor', 'label' => 'Depachado Por']
        ];

        # estaba depurando
        $this->fecha_alfa_desde = date('Y-m-d');
        $this->fecha_alfa_hasta = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.cca.reportes.reporte-personalizado');
    }
}
