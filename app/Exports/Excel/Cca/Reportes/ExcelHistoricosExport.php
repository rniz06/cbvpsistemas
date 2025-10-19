<?php

namespace App\Exports\Excel\Cca\Reportes;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelHistoricosExport implements FromCollection, WithHeadings, WithMapping
{
    public $query;

    public function __construct($query = null)
    {
        $this->query = $query;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return ['Compañia', 'Servicio', 'Clasificación', 'Móvil', 'A Cargo', 'Chofer', 'Tripulantes', 'Fecha y Hora'];
    }

    public function map($historico): array
    {
        return [
            $historico->compania ?? 'S/D',
            $historico->servicio ?? 'S/D',
            $historico->clasificacion ?? 'S/D',
            $historico->movil ?? 'S/D',
            $historico->acargo ?? '',
            $historico->chofer ?? 'S/D',
            $historico->cantidad_tripulantes ?? 'S/D',
            !empty($historico->fecha_alfa) ? date('d/m/Y H:i:s', strtotime($historico->fecha_alfa)) : 'S/D',
        ];
    }
}