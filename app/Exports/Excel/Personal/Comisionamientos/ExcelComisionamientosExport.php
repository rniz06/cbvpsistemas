<?php

namespace App\Exports\Excel\Personal\Comisionamientos;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelComisionamientosExport implements FromCollection, WithHeadings, WithMapping
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
        return ['Nombre - Código', 'Cargo', 'Rango', 'Comisionado', 'En', 'Códido Rad.', 'Culminado', 'Fecha Inicio', 'Fecha Fin'];
    }

    public function map($comisionamiento): array
    {
        $culminado = $comisionamiento->culminado ? 'SI' : 'NO';

        return [
            $comisionamiento->nombre_codigo ?? 'S/D',
            $comisionamiento->cargo ?? 'S/D',
            $comisionamiento->rango ?? 'S/D',
            $comisionamiento->compania ?? 'S/D',
            $comisionamiento->direccion ?? '',
            $comisionamiento->codigo_comisionamiento ?? 'S/D',
            $culminado,
            !empty($comisionamiento->fecha_inicio) ? date('d/m/Y', strtotime($comisionamiento->fecha_inicio)) : 'S/D',
            !empty($comisionamiento->fecha_fin) ? date('d/m/Y', strtotime($comisionamiento->fecha_fin)) : 'S/D',
        ];
    }
}