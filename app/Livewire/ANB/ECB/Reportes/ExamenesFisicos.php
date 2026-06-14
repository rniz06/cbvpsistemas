<?php

namespace App\Livewire\ANB\ECB\Reportes;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\ANB\ECB\ResultadoExamenFisico;
use App\Models\ANB\ECB\ExamenFisico;

class ExamenesFisicos extends Component
{
    use WithPagination;

    public $examen_id = '';

    public $estado = '';

    public function render()
    {
        $resultados = ResultadoExamenFisico::query()

            ->with([
                'aspirante.compania',
                'examen'
            ])

            ->when($this->examen_id, function ($q) {

                $q->where(
                    'examen_fisico_id',
                    $this->examen_id
                );

            })

            ->when($this->estado !== '', function ($q) {

                $q->where(
                    'aprobado',
                    $this->estado
                );

            })

            ->paginate(20);

        return view(
            'livewire.anb.ecb.reportes.examenes-fisicos',
            [
                'resultados' => $resultados,
                'examenes' => ExamenFisico::orderBy('nombre')->get()
            ]
        );
    }
}