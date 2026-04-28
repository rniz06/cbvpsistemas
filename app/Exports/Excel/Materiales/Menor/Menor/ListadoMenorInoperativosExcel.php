<?php

namespace App\Exports\Excel\Materiales\Menor\Menor;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ListadoMenorInoperativosExcel implements FromCollection, WithHeadings, WithMapping
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

    public function map($inoperativo): array
    {
        return [
            $inoperativo->componente->nombre ?? 'S/D',
            $inoperativo->marca->nombre ?? 'S/D',
            $inoperativo->compania->compania ?? 'S/D'
        ];
    }
}
