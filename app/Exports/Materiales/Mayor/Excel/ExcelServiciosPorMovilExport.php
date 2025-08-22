<?php

namespace App\Exports\Materiales\Mayor\Excel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelServiciosPorMovilExport implements FromCollection, WithHeadings, WithMapping
{
    public $datos;

    public function __construct($datos = null)
    {
        $this->datos = $datos;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->datos;
    }

    public function headings(): array
    {
        return ['Móvil', 'Compañía', 'Servicio', 'Fecha y Hora', 'Conductor', 'A cargo'];
    }

    public function map($servicio): array
    {
        // Conductor
        if ($servicio->chofer_rentado == 1) {
            $conductor = 'Rentado';
        } elseif (!empty($servicio->chofer_nombrecompleto)) {
            $conductor = ($servicio->chofer_nombrecompleto ?? 'S/D') . ' - ' .
                         ($servicio->chofer_codigo ?? 'S/D') . ' - ' .
                         ($servicio->chofer_categoria ?? 'S/D');
        } elseif (!empty($servicio->chofer_aux)) {
            $conductor = $servicio->chofer_aux;
        } else {
            $conductor = 'S/D';
        }

        // A cargo
        if (empty($servicio->acargo_nombrecompleto) && !empty($servicio->acargo_aux)) {
            $acargo = $servicio->acargo_aux;
        } elseif (!empty($servicio->acargo_nombrecompleto)) {
            $acargo = ($servicio->acargo_nombrecompleto ?? 'S/D') . ' - ' .
                      ($servicio->acargo_codigo ?? 'S/D') . ' - ' .
                      ($servicio->acargo_categoria ?? 'S/D');
        } else {
            $acargo = 'S/D';
        }

        return [
            $servicio->movil ?? 'S/D',
            $servicio->compania ?? 'S/D',
            $servicio->servicio ?? 'S/D',
            !empty($servicio->fecha_alfa) ? date('d/m/Y H:i:s', strtotime($servicio->fecha_alfa)) . ' Hs.' : 'S/D',
            $conductor,
            $acargo,
        ];
    }
}