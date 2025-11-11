<?php

namespace App\Exports\Excel\Materiales\Mayor;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelMayorInoperativosExport implements FromCollection, WithHeadings, WithMapping
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
        return ['Móvil', 'Compañía', 'Año', 'Chapa', 'Motivo', 'Detalle'];
    }

    public function map($movil): array
    {
        $mayor = $movil->acronimo->tipo . '-' . $movil->movil;
        return [
            $mayor ?? 'S/D',
            $movil->compania->compania ?? 'S/D',
            $movil->anho ?? 'S/D',
            $movil->chapa ?? 'S/D',
            $movil->ultimoComentarioFueraServicio?->motivo?->categoria ?? 'S/D',
            $movil->ultimoComentarioFueraServicio?->detalle?->detalle ?? 'S/D',
            // !empty($servicio->fecha_alfa) ? date('d/m/Y H:i:s', strtotime($servicio->fecha_alfa)) . ' Hs.' : 'S/D',
        ];
    }
}