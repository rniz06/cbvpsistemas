<?php

namespace App\Livewire\Materiales\Menor\Categorias;

use App\Models\Materiales\Menor\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModalCreate extends Component
{
    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $nombre;

    # REGLAS DE VALIDACION
    protected function rules()
    {
        return [
            'nombre'       => ['required', 'string', 'max:100', Rule::unique(Categoria::class, 'nombre')->withoutTrashed()],
        ];
    }

    # FUNCION PARA GUARDAR UN NUEVO REGISTRO
    public function guardar()
    {
        $this->validate();

        try {
            Categoria::create([
                'nombre'       => $this->nombre,
                'creadoPor'    => Auth::id(),
            ]);
            session()->flash('success', 'REGISTRADO CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO REGISTRAR');
        }

        $this->redirectRoute('materiales.menor.categorias.index');
    }

    public function render()
    {
        return view('livewire.materiales.menor.categorias.modal-create');
    }

    # FUNCION QUE ESCUCHA BTN CERRAR DEL MODAL Y RESETEA LOS CAMPOS
    public function resetForm()
    {
        $this->reset(['nombre']);
        $this->resetValidation('nombre');
    }
}
