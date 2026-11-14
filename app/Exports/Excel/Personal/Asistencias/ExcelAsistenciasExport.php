<?php

namespace App\Exports\Excel\Personal\Asistencias;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExcelAsistenciasExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnFormatting
{
    public $asistencia, $detalles;

    public function __construct($asistencia = null, $detalles = null)
    {
        $this->asistencia = $asistencia;
        $this->detalles = $detalles;
    }

    public function collection()
    {
        return $this->detalles;
    }

    public function headings(): array
    {
        return [
            'Voluntario',
            'Código',
            'Práctica',
            'Guardia',
            'Citación',
            'Total',
            'Compañia',
            'Periodo',
        ];
    }

    public function map($detalle): array
    {
        $periodo = $this->asistencia->periodo->mes->mes . '/' .
            $this->asistencia->periodo->anho->anho;

        $compania = $this->asistencia->compania->compania ?? 'S/D';

        return [
            $detalle->personal->nombrecompleto ?? 'S/D',
            $detalle->personal->codigo ?? 'S/D',
            $detalle->practica !== null ? (float) $detalle->practica : 'S/D',
            $detalle->guardia !== null ? (float) $detalle->guardia : 'S/D',
            $detalle->citacion !== null ? (float) $detalle->citacion : 'NO APLICA',
            $detalle->total !== null ? (float) $detalle->total : 'S/D',
            $compania,
            $periodo,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_00,
            'D' => NumberFormat::FORMAT_NUMBER_00,
            'E' => NumberFormat::FORMAT_NUMBER_00,
            'F' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}