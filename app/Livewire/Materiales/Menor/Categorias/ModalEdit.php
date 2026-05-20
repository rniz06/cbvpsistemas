<?php

namespace App\Livewire\Materiales\Menor\Categorias;

use App\Models\Materiales\Menor\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModalEdit extends Component
{
    # REGISTRO ACTUAL
    public $registro;
    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $nombre;

    public function mount(Categoria $categoria)
    {
        $this->registro      = $categoria;
        # RELLENAR CAMPO NOMBRE
        $this->nombre          = $categoria->nombre ?? '';
    }

    # REGLAS DE VALIDACION
    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:100', Rule::unique(Categoria::class, 'nombre')->withoutTrashed()->ignore($this->registro->id_menor_categoria, 'id_menor_categoria')],
        ];
    }

    # FUNCION PARA ACTUALIZAR UN REGISTRO
    public function guardar()
    {
        $this->validate();

        try {
            $this->registro->update([
                'nombre'         => $this->nombre,
                'actualizadoPor' => Auth::id(),
            ]);
            session()->flash('success', 'ACTUALIZADO CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO ACTUALIZAR');
        }

        $this->redirectRoute('materiales.menor.categorias.index');
    }

    public function render()
    {
        return view('livewire.materiales.menor.categorias.modal-edit');
    }

    # FUNCION QUE ESCUCHA BTN CERRAR DEL MODAL Y RESETEA LOS CAMPOS
    public function resetForm()
    {
        $this->reset(['nombre']);
        $this->resetValidation('nombre');
    }
}
