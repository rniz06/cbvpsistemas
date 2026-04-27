<?php

namespace App\Exports\Excel\Materiales\Menor\Componentes;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelMenorComponentesExport implements FromCollection, WithHeadings, WithMapping
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
        return ['Nombre', 'Componente de', 'Categoria'];
    }

    public function map($componente): array
    {
        return [
            $componente->nombre ?? 'S/D',
            $componente->tipo->tipo ?? 'S/D',
            $componente->categoria->nombre ?? 'S/D',
        ];
    }
}