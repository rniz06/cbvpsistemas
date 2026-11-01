<?php

namespace App\Exports\Excel\Cca\Operatividad;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExcelCondicionGuardiaCompaniaExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithEvents
{
    private Collection $query;

    public function __construct(Collection $query)
    {
        $this->query = $query;
    }

    public function collection(): Collection
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'Estado',
            'A cargo',
            'Personal',
            'Conductores',
            'Móviles',
            'Autónomos',
            'Espuma',
            'Hidráulico',
            'Pileta',
            'Comunicado Por',
            'Fecha Hora',
        ];
    }

    public function map($condicion): array
    {
        $acargo = $condicion->acargo_aux
            ?? $condicion->acargo_rel?->categoria_codigo_juramento
            ?? 'S/D';

        return [
            $this->obtenerEstado($condicion)['texto'],
            $acargo,
            $condicion->cant_personal ?? 'S/D',
            $condicion->cant_conductor ?? 'S/D',
            $this->formatearMoviles($condicion->moviles),
            $condicion->cant_autonomo ?? 'S/D',
            $condicion->cant_espuma ?? 'S/D',
            $condicion->equipo_hidraulico ? 'Operativo' : 'Inoperativo',
            $condicion->pileta ? 'Operativo' : 'Inoperativo',
            $condicion->comunicado_por ?? 'S/D',
            $condicion->fecha_hora?->format('d/m/Y H:i') ?? 'S/D',
        ];
    }

    private function formatearMoviles($moviles): string
    {
        if (!$moviles || $moviles->isEmpty()) {
            return 'Operativos: Ninguno | Inoperativos: Ninguno';
        }

        $operativos = [];
        $inoperativos = [];

        foreach ($moviles as $operatividadMovil) {

            $movil = $operatividadMovil->movil;

            if (!$movil) {
                continue;
            }

            $acronimo = $movil->acronimo?->tipo ?? 'S/D';
            $numero = $movil->movil ?? 'S/D';

            $identificador = "{$acronimo}-{$numero}";

            if ($operatividadMovil->operativo) {
                $operativos[] = $identificador;
            } else {
                $inoperativos[] = $identificador;
            }
        }

        return 'Operativos: ' .
            (!empty($operativos) ? implode(', ', $operativos) : 'Ninguno') .
            ' | Inoperativos: ' .
            (!empty($inoperativos) ? implode(', ', $inoperativos) : 'Ninguno');
    }

    private function obtenerEstado($condicion): array
    {
        if (!$condicion->operativo) {
            return [
                'texto' => 'INOPERATIVO',
                'color' => 'FFC7CE',
            ];
        }

        if (($condicion->cant_personal ?? 0) == 0) {
            return [
                'texto' => 'OPERATIVO',
                'color' => 'FFEB9C',
            ];
        }

        if (($condicion->cant_conductor ?? 0) == 0) {
            return [
                'texto' => 'OPERATIVO',
                'color' => 'BEE5EB',
            ];
        }

        return [
            'texto' => 'OPERATIVO',
            'color' => 'C6EFCE',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $fila = 2;

                foreach ($this->query as $condicion) {

                    $estado = $this->obtenerEstado($condicion);

                    $sheet->getStyle("A{$fila}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => $estado['color'],
                            ],
                        ],
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);

                    $sheet->getStyle("E{$fila}")
                        ->getAlignment()
                        ->setWrapText(true);

                    $sheet->getRowDimension($fila)->setRowHeight(-1);

                    $fila++;
                }

                $sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '343A40'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

                foreach (range('A', 'K') as $columna) {
                    $sheet->getColumnDimension($columna)->setAutoSize(true);
                }

                $sheet->getColumnDimension('E')->setWidth(35);

                $sheet->freezePane('A2');

                $ultimaFila = $sheet->getHighestRow();

                if ($ultimaFila >= 2) {
                    $sheet->setAutoFilter("A1:K{$ultimaFila}");
                }
            },
        ];
    }
}
