<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Detalle;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Carga extends Component
{
    public $asistencia, $detalle, $asistencia_detalle_id;

    #[Validate]
    public $practica, $guardia, $citacion;

    public $bloqueoCitacion = true;

    public function mount($asistencia_detalle_id, $asistencia)
    {
        $this->asistencia_detalle_id = $asistencia_detalle_id;
        $this->asistencia = $asistencia;
        $this->detalle = Detalle::with('personal:idpersonal,nombrecompleto,codigo')->findOrFail($asistencia_detalle_id);

        // Inicializar valores (si ya existen)
        $this->practica = $this->detalle->practica ?? null;
        $this->guardia  = $this->detalle->guardia ?? null;
        $this->citacion = $this->detalle->citacion ?? null;

        // Si hubo_citacion es false, entonces bloquea la citación
        $this->bloqueoCitacion = !$this->asistencia->hubo_citacion;
    }

    protected function rules()
    {
        return [
            'practica' => ['required', 'numeric', 'min_digits:1', 'max_digits:3', 'min:0', 'max:100'],
            'guardia'  => ['required', 'numeric', 'min_digits:1', 'max_digits:3', 'min:0', 'max:100'],
            'citacion' => ['nullable', 'numeric', 'min_digits:1', 'max_digits:3', 'min:0', 'max:100'],
        ];
    }

    public function grabar()
    {
        $this->validate();
        Detalle::findOrFail($this->detalle->id_asistencia_detalle)->update([
            'practica' => $this->practica,
            'guardia'  => $this->guardia,
            'citacion' => $this->citacion,
        ]);
        session()->flash('success', 'Registrado Correctamente!');
        $this->redirectRoute('personal.asistencias.show', $this->detalle->asistencia_id);
    }

    public function render()
    {
        return view('livewire.personal.asistencias.carga');
    }
}
