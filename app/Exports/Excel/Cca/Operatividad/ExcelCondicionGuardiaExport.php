<?php

namespace App\Exports\Excel\Cca\Operatividad;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExcelCondicionGuardiaExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
        return ['Compañia', 'Acargo', 'Cantidad Personal'];
    }

    public function map($condicion): array
    {
        $acargo = $condicion->ultimaOperatividad?->acargo_aux ??
            ($condicion->ultimaOperatividad?->acargo_rel?->categoria_codigo_juramento ?? 'S/D');
        return [
            $condicion->compania ?? 'S/D',
            $acargo ?? 'S/D',
            $condicion->ultimaOperatividad->cant_personal ?? 'S/D'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // La fila 1 corresponde a los encabezados
                $fila = 2;

                foreach ($this->query as $condicion) {

                    $color = $condicion->cca_operativo
                        ? 'C6EFCE' // Verde
                        : 'FFC7CE'; // Rojo

                    $sheet->getStyle("A{$fila}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => $color,
                            ],
                        ],
                    ]);

                    $fila++;
                }
            },
        ];
    }
}
