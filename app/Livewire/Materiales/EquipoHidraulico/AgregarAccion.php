<?php

namespace App\Livewire\Materiales\EquipoHidraulico;

use App\Actions\Materiales\Hidraulicos\PasarHerramientaAInoperativo;
use App\Models\Materiales\Accion;
use App\Models\Materiales\EquipoHidraulico\Comentario;
use App\Models\Materiales\EquipoHidraulico\Herramienta;
use App\Models\Materiales\EquipoHidraulico\Hidraulico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AgregarAccion extends Component
{
    public $hidraulico_id;
    public $accion_id = '';
    public $compania_id = '';
    public $comentario = '';
    public $herramientas = []; # ARRAY PARA HERRAMIENTAS A PONER INOPERATIVOS
    public $herramientaSeleccionada; # HERRAMIENTA SELECCIONADA

    protected function rules()
    {
        return [
            'hidraulico_id' => ['required', Rule::exists(Hidraulico::class, 'id_hidraulico')],
            'accion_id' => ['required', Rule::exists(Accion::class, 'id_accion')],
            'comentario' => ['required', 'string', 'max:65535'],
        ];
    }

    public function mount($hidraulico_id)
    {
        $this->hidraulico_id = $hidraulico_id;
    }

    public function guardar(PasarHerramientaAInoperativo $action)
    {
        $this->validate();
        $hidraulico = Hidraulico::findOrFail($this->hidraulico_id);
        switch ($this->accion_id) {
            case 1:
                $hidraulico->update([
                    'operatividad_id' => 1,
                ]);
                break;
            case 2:
                $hidraulico->update([
                    'operatividad_id' => 0,
                ]);
                # SOLO ejecutar si seleccionó una herramienta válida
                if (!empty($this->herramientaSeleccionada) && $this->herramientaSeleccionada != 0) {
                    $action->handle((int) $this->herramientaSeleccionada);
                }
                break;
        }
        # GUARDAR COMENTARIO DE LA FICHA
        Comentario::create([
            'hidraulico_id' => $this->hidraulico_id,
            'accion_id' => $this->accion_id,
            'comentario' => $this->comentario,
            'creadoPor' => Auth::id(),
        ]);
        session()->flash('success', 'Comentario Guardado Exitosamente!');
        $this->redirectRoute('materiales.hidraulicos.show', ['hidraulico' => $this->hidraulico_id]);
    }

    public function render()
    {
        return view('livewire.materiales.equipo-hidraulico.agregar-accion');
    }

    public function updatedAccionId($value)
    {
        if ($value == 2) { # FUERA DE SERVICIO
            $this->herramientas = Herramienta::select('id_hidraulico_herr', 'tipo_id')
                ->where('hidraulico_id', $this->hidraulico_id)
                ->with(['tipo:idhidraulico_herr_tipo,tipo'])->get();
        }
    }
}
