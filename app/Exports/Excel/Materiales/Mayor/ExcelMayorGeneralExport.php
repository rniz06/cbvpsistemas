<?php

namespace App\Exports\Excel\Materiales\Mayor;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelMayorGeneralExport implements FromCollection, WithHeadings, WithMapping
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
        return ['Móvil', 'Compañía', 'Marca', 'Modelo', 'Transmion', 'Eje', 'Combustible', 'Estado', 'Año', 'Chapa', 'C. delanteras', 'C. traseras'];
    }

    public function map($movil): array
    {
        return [
            $movil->movil ?? 'S/D',
            $movil->compania ?? 'S/D',
            $movil->marca ?? 'S/D',
            $movil->modelo ?? 'S/D',
            $movil->transmision ?? 'S/D',
            $movil->eje ?? 'S/D',
            $movil->combustible ?? 'S/D',
            $movil->operatividad ?? 'S/D',
            $movil->anho ?? 'S/D',
            $movil->chapa ?? 'S/D',
            $movil->cubiertas_frente ?? 'S/D',
            $movil->cubiertas_atras ?? 'S/D',
            // !empty($servicio->fecha_alfa) ? date('d/m/Y H:i:s', strtotime($servicio->fecha_alfa)) . ' Hs.' : 'S/D',
        ];
    }
}