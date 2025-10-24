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
                'periodo:id_asistencia_periodo,anho_id,mes_id',
                'estado:id_asistencia_estado,estado'
            ])->findOrFail($asistencia);
    }

    public function render()
    {
        return view('livewire.personal.asistencias.show');
    }
}
