<?php

namespace App\Livewire\Personal\Asistencias;

use App\Enums\Personal\Asistencias\Accion;
use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Comentario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModalRechazoPersonal extends Component
{
    # REGISTRO DE ASISTENCIA
    public $asistencia;
    # CAMPOS DEL FORMULARIO
    #[Validate]
    public $comentario;

    public function mount(Asistencia $asistencia)
    {
        $this->asistencia = $asistencia;
    }

    protected function rules()
    {
        return [
            'comentario' => ['required', 'string', 'max:255']
        ];
    }

    public function guardar()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                Comentario::create([
                    'comentario'    => $this->comentario ?? null,
                    'accion'        => Accion::RECHAZO,
                    'asistencia_id' => $this->asistencia->id_asistencia ?? null,
                    'creadoPor'     => Auth::id() ?? null,
                ]);

                $this->asistencia->update([
                    'estado_id' => 5, # ESTADO: RECHAZADO POR PERSONAL
                ]);
            });

            session()->flash('success', 'LA PLANILLA DE ASISTENCIA FUE RECHAZADA Y REMITIDA A LA COMPAÑIA!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO RECHAZAR LA PLANILLA ' . $e->getMessage());
        }

        return redirect()->route('personal.asistencias.show', $this->asistencia->id_asistencia);
    }

    public function render()
    {
        return view('livewire.personal.asistencias.modal-rechazo-personal');
    }

    #[On('cerrar-modal')]
    public function resetarForm()
    {
        $this->reset('comentario');
        $this->resetValidation();
    }
}
