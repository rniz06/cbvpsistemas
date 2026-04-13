<?php

namespace App\Livewire\Materiales\Menor\Componentes;

use App\Models\Materiales\Menor\Componente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModalEdit extends Component
{
    /*
    |-----------------------------------------------------
    | COMPONENTE MODAL CON FORMULARIO DE EDIT DE COMPONENTE
    | SE REALIZA COMO MODAL PARA USARLO EN VARIOS 
    | MODULOS(MAT. MENOR, EQUIPOS FORESTALES, ERAS)
    |-----------------------------------------------------
    */
    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $nombre;

    public $componente, $routeToRedirect, $categoriaId;

    public function mount(Componente $componente, $routeToRedirect, $categoriaId)
    {
        $this->componente      = $componente;
        $this->routeToRedirect = $routeToRedirect ?? 'home';
        $this->categoriaId     = $categoriaId;

        # RELLENAR CAMPO NOMBRE
        $this->nombre          = $componente->nombre ?? '';
    }

    # REGLAS DE VALIDACION
    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:100', Rule::unique(Componente::class, 'nombre')
                ->where('categoria_id', $this->categoriaId)->withoutTrashed()->ignore($this->componente->id_menor_componente, 'id_menor_componente')]
        ];
    }

    # FUNCION PARA ACTUALIZAR UN REGISTRO
    public function grabar()
    {
        $this->validate();

        try {
            $this->componente->update([
                'nombre'         => $this->nombre,
                'categoria_id'   => $this->categoriaId,
                'actualizadoPor' => Auth::id(),
            ]);
            session()->flash('success', 'COMPONENTE ACTUALIZADO CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO ACTUALIZAR - ' . $e->getMessage());
        }

        $this->redirectRoute($this->routeToRedirect);
    }

    public function render()
    {
        return view('livewire.materiales.menor.componentes.modal-edit');
    }

    # FUNCION QUE ESCUCHA BTN CERRAR DEL MODAL Y RESETEA LOS CAMPOS
    public function resetForm()
    {
        $this->reset('nombre');
        $this->resetValidation('nombre');
    }
}
