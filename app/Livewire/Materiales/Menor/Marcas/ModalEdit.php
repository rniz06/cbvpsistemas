<?php

namespace App\Livewire\Materiales\Menor\Marcas;

use App\Models\Materiales\Menor\Marca;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModalEdit extends Component
{
    /*
    |----------------------------------------------------
    | COMPONENTE MODAL CON FORMULARIO DE EDICION DE MARCA
    |----------------------------------------------------
    */

    # PROPIEDAD PARA ALMACENAR EL REGISTRO A EDITAR
    public $registro;

    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $nombre;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount($marca_id)
    {
        $this->registro  = Marca::findOrFail($marca_id);

        $this->nombre    = $this->registro->nombre;
    }

    # REGLAS DE VALIDACION
    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:50', Rule::unique(Marca::class, 'nombre')->withoutTrashed()->ignore($this->registro->id_menor_marca, 'id_menor_marca')],
        ];
    }

    # FUNCION PARA ACTUALIZAR EL REGISTRO
    public function grabar()
    {
        $this->validate();

        try {
            $this->registro->update([
                'nombre'          => $this->nombre,
                'actualizadoPor'  => Auth::id(),
            ]);
            session()->flash('success', 'MARCA ACTUALIZADA CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO ACTUALIZAR LA MARCA - ' . $e->getMessage());
        }

        $this->redirectRoute('materiales.menor.marcas.index');
    }

    public function render()
    {
        return view('livewire.materiales.menor.marcas.modal-edit');
    }
}
