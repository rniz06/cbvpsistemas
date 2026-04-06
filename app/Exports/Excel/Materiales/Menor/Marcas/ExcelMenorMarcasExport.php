<?php

namespace App\Exports\Excel\Materiales\Menor\Marcas;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelMenorMarcasExport implements FromCollection, WithHeadings, WithMapping
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
        return ['Nombre'];
    }

    public function map($marca): array
    {
        return [
            $marca->nombre ?? 'S/D',
        ];
    }
}