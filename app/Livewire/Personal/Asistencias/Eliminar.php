<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal\Asistencia\Asistencia;
use Livewire\Component;

class Eliminar extends Component
{
    # PROPIEDAD PARA GUARDAR EL REGISTRO DE ASISTENCIA OBTENIDO
    public $asistencia;

    public function mount(Asistencia $asistencia)
    {
        $this->asistencia = $asistencia;    
    }

    public function eliminar()
    {
        try {
            $this->asistencia->delete();
            session()->flash('success', 'PERIODO DE ASISTENCIA ELIMINADO CORRECTAMENTE');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO ELIMINAR EL PERIODO DE ASISTENCIA ' . $e->getMessage());
        }

        # REDIRECCIONAR
        return redirect()->route('personal.asistencias.index');    
    }

    public function render()
    {
        return view('livewire.personal.asistencias.eliminar');
    }
}
