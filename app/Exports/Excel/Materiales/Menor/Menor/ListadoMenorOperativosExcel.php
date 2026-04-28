<?php

namespace App\Exports\Excel\Materiales\Menor\Menor;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ListadoMenorOperativosExcel implements FromCollection, WithHeadings, WithMapping
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
        return ['Nombre', 'Marca', 'Compañia'];
    }

    public function map($operativo): array
    {
        return [
            $operativo->componente->nombre ?? 'S/D',
            $operativo->marca->nombre ?? 'S/D',
            $operativo->compania->compania ?? 'S/D'
        ];
    }
}
