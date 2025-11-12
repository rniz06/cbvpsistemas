<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal\Asistencia\Asistencia;
use Livewire\Component;

class Show extends Component
{   
    public $asistencia;

    public function mount($asistencia)
    {
        $this->asistencia = Asistencia::select('id_asistencia', 'compania_id', 'periodo_id', 'estado_id')
            ->with([
                'compania:id_compania,compania',
                'estado:id_asistencia_estado,estado',
                'periodo.anho:id_anho,anho',
                'periodo.mes:id_mes,mes',
            ])->findOrFail($asistencia);
    }

    public function render()
    {
        return view('livewire.personal.asistencias.show');
    }
}
