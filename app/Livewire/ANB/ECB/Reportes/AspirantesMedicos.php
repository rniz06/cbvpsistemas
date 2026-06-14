<?php

namespace App\Livewire\ANB\ECB\Reportes;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\ANB\ECB\Aspirante;
use App\Models\ANB\ECB\Llamado;

class AspirantesMedicos extends Component
{
    use WithPagination;

    public $llamado_id = '';

    public $estado = '';

    public function render()
    {
        $aspirantes = Aspirante::query()

            ->with([
                'compania',
                'llamado',
                'fichaMedica'
            ])

            ->when($this->llamado_id, function ($q) {

                $q->where(
                    'llamado_id',
                    $this->llamado_id
                );

            })

            ->when($this->estado, function ($q) {

                $q->where(
                    'estado',
                    $this->estado
                );

            })

            ->paginate(20);

        return view(
            'livewire.anb.ecb.reportes.aspirantes-medicos',
            [
                'aspirantes' => $aspirantes,
                'llamados'   => Llamado::orderBy('id','desc')->get()
            ]
        );
    }
}