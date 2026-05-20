<?php

namespace App\Livewire\Materiales\Menor\Componentes;

use App\Models\Materiales\Menor\Categoria;
use App\Models\Materiales\Menor\Componente;
use App\Models\Materiales\Menor\Tipo;
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
    
    # REGISTRO ACTUAL
    public $registro;
    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $nombre, $tipo_id, $categoria_id;

    # PROPIEDADES PARA LOS SELECTS
    public $tipos = [], $categorias;

    public function mount(Componente $componente)
    {
        $this->registro      = $componente;
        # RELLENAR CAMPO NOMBRE
        $this->nombre          = $componente->nombre ?? '';
        $this->tipo_id         = $componente->tipo_id ?? '';
        $this->categoria_id    = $componente->categoria_id ?? '';

        $this->tipos      = Tipo::orderBy('tipo')->get(['id_menor_tipo', 'tipo']);
        $this->categorias = Categoria::orderBy('nombre')->get(['id_menor_categoria', 'nombre']);
    }

    # REGLAS DE VALIDACION
    protected function rules()
    {
        return [
            'nombre'       => ['required', 'string', 'max:100', Rule::unique(Componente::class, 'nombre')->withoutTrashed()->ignore($this->registro->id_menor_componente, 'id_menor_componente')],
            'tipo_id'      => ['required', Rule::exists(Tipo::class, 'id_menor_tipo')],
            'categoria_id' => ['nullable', Rule::exists(Categoria::class, 'id_menor_categoria')]
        ];
    }

    # FUNCION PARA ACTUALIZAR UN REGISTRO
    public function guardar()
    {
        $this->validate();

        try {
            $this->registro->update([
                'nombre'         => $this->nombre,
                'tipo_id'        => $this->tipo_id,
                'categoria_id'   => $this->categoria_id === '' ? null : $this->categoria_id,
                'actualizadoPor' => Auth::id(),
            ]);
            session()->flash('success', 'COMPONENTE ACTUALIZADO CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO ACTUALIZAR' . $e->getMessage());
        }

        $this->redirectRoute('materiales.menor.componentes.index');
    }

    public function render()
    {
        return view('livewire.materiales.menor.componentes.modal-edit');
    }

    # FUNCION QUE ESCUCHA BTN CERRAR DEL MODAL Y RESETEA LOS CAMPOS
    public function resetForm()
    {
        $this->reset(['nombre', 'tipo_id', 'categoria_id']);
        $this->resetValidation('nombre');
        $this->resetValidation('tipo_id');
        $this->resetValidation('categoria_id');
    }
}
