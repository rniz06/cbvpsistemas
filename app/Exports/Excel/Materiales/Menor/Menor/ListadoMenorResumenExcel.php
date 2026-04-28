<?php

namespace App\Exports\Excel\Materiales\Menor\Menor;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ListadoMenorResumenExcel implements FromCollection, WithHeadings, WithMapping
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
        return ['Nombre', 'Marca', 'Operativos', 'Inoperativos'];
    }

    public function map($resumen): array
    {
        return [
            $resumen->componente ?? 'S/D',
            $resumen->marca ?? 'S/D',
            $resumen->operativos ?? 'S/D',
            $resumen->inoperativos ?? 'S/D',
        ];
    }
}
