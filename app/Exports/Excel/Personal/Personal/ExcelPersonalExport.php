<?php

namespace App\Exports\Excel\Personal\Personal;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelPersonalExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    public $query;

    public function __construct($query = null)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function chunkSize(): int
    {
        return 1000; // procesa de 1000 en 1000
    }

    public function headings(): array
    {
        return [
            'Nombre Completo',
            'Codigo',
            'Documento',
            'Año Juramento',
            'Fecha Juramento',
            'Categoria',
            'Estado',
            'Actualizar',
            'Nacionalidad',
            'Sexo',
            'Grupo Sanguineo',
            'Compañia'
        ];
    }

    public function map($personal): array
    {
        return [
            $personal->nombrecompleto ?? 'S/D',
            $personal->codigo ?? 'S/D',
            $personal->documento ?? 'S/D',
            $personal->fecha_juramento ?? 'S/D',
            $personal->fecha_de_juramento ?? '',
            $personal->categoria ?? 'S/D',
            $personal->estado ?? 'S/D',
            $personal->estado_actualizar ?? 'S/D',
            $personal->pais ?? 'S/D',
            $personal->sexo ?? 'S/D',
            $personal->grupo_sanguineo ?? 'S/D',
            $personal->compania ?? 'S/D',
        ];
    }
}
