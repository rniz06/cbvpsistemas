<?php

namespace App\Livewire\Materiales\EquipoHidraulico\Herramientas;

use App\Models\Materiales\Accion;
use App\Models\Materiales\EquipoHidraulico\Herramienta;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Comentario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AgregarAccion extends Component
{
    public $herramienta_id;
    public $hidraulico_id;
    public $accion_id = '';
    public $comentario = '';

    protected function rules()
    {
        return [
            'herramienta_id' => ['required', Rule::exists(Herramienta::class, 'id_hidraulico_herr')],
            'accion_id' => ['required', Rule::exists(Accion::class, 'id_accion')],
            'comentario' => ['required', 'string', 'max:65535'],
        ];
    }
    public function mount($herramienta_id)
    {
        $this->herramienta_id = $herramienta_id;
    }

    public function guardar()
    {
        $this->validate();
        $herramienta = Herramienta::findOrFail($this->herramienta_id);
        switch ($this->accion_id) {
            case 1:
                $herramienta->update([
                    'operatividad_id' => 1,
                ]);
                break;
            case 2:
                $herramienta->update([
                    'operatividad_id' => 0,
                ]);
                break;
        }
        Comentario::create([
            'herramienta_id' => $this->herramienta_id,
            'accion_id' => $this->accion_id,
            'comentario' => $this->comentario,
            'creadoPor' => Auth::id(),
        ]);
        session()->flash('success', 'Comentario Guardado Exitosamente!');
        $this->redirectRoute('materiales.hidraulicos.herramientas.show', ['hidraulico' => $this->hidraulico_id, 'herramienta' => $this->herramienta_id]);
    }

    public function render()
    {
        return view('livewire.materiales.equipo-hidraulico.herramientas.agregar-accion');
    }
}
