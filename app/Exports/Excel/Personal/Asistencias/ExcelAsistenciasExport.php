<?php

namespace App\Exports\Excel\Personal\Asistencias;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelAsistenciasExport implements FromCollection, WithHeadings, WithMapping
{
    public $asistencia, $detalles;

    public function __construct($asistencia = null, $detalles = null)
    {
        $this->asistencia = $asistencia;
        $this->detalles = $detalles;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->detalles;
    }

    public function headings(): array
    {
        return ['Voluntario', 'Código', 'Práctica', 'Guardia', 'Citación', 'Total', 'Compañia', 'Periodo'];
    }

    public function map($detalle): array
    {
        $periodo = $this->asistencia->periodo->mes->mes . '/' . $this->asistencia->periodo->anho->anho;
        $compania = $this->asistencia->compania->compania ?? 'S/D';

        return [
            $detalle->personal->nombrecompleto ?? 'S/D',
            $detalle->personal->codigo ?? 'S/D',
            $detalle->practica ?? 'S/D',
            $detalle->guardia ?? 'S/D',
            $detalle->citacion !== null ? $detalle->citacion : 'NO APLICA',
            $detalle->total ?? 'S/D',
            $compania ?? 'S/D',
            $periodo ?? 'S/D',
        ];
    }
}