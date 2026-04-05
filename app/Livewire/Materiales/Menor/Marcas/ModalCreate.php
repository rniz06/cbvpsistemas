<?php

namespace App\Livewire\Materiales\Menor\Marcas;

use App\Models\Materiales\Menor\Marca;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModalCreate extends Component
{
    /*
    |-------------------------------------------------
    | COMPONENTE MODAL CON FORMULARIO DE ALTA DE MARCA
    |-------------------------------------------------
    */
    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $nombre;

    # REGLAS DE VALIDACION
    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:50', Rule::unique(Marca::class, 'nombre')]
        ];
    }

    # FUNCION PARA GUARDAR UN NUEVO COLOR
    public function grabar()
    {
        $this->validate();

        try {
            Marca::create([
            'nombre'     => $this->nombre,
            'creadoPor'  => Auth::id(),
        ]);
        session()->flash('success', 'MARCA REGISTRADA CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO CREAR LA COMPAÑIA - ' . $e->getMessage());
        }
        
        $this->redirectRoute('materiales.menor.marcas.index');
    }

    public function render()
    {
        return view('livewire.materiales.menor.marcas.modal-create');
    }

    # FUNCION QUE ESCUCHA BTN CERRAR DEL MODAL Y RESETEA LOS CAMPOS
    public function resetForm()
    {
        $this->reset('nombre');    
    }
}
