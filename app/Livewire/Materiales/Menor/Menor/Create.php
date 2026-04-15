<?php

namespace App\Livewire\Materiales\Menor\Menor;

use App\Models\Materiales\Menor\Componente;
use App\Models\Materiales\Menor\Item;
use App\Models\Materiales\Menor\Marca;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    /*
    |------------------------------------------------------
    | RENDERIZA FORM DE ALTA DE MATERIAL MENOR
    / RECIBE UN ID DE COMPANIA POR QUE EL FORM SE MUESTRA
    / EN materiales.menor.ver-compania
    |------------------------------------------------------
    */

    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $componente_id, $cantidad_operativo = 0, $cantidad_inoperativo = 0, $compania_id;

    # PROPIEDADES DE LOS SELECTS
    public $componentes, $marcas;

    public function mount(int $companiaId)
    {
        $this->componentes  = Componente::menor()->orderBy('nombre')->get(['id_menor_componente', 'nombre']);
        $this->compania_id  = $companiaId; # ID DE COMPANIA RECIBIDA
    }

    protected function rules()
    {
        return [
            'componente_id'  => [
                'required',
                Rule::exists(Componente::class, 'id_menor_componente'),
                Rule::unique(Item::class, 'componente_id')->where('compania_id', $this->compania_id)
            ],
            'cantidad_operativo' => ['required', 'integer', 'min:0'],
            'cantidad_inoperativo' => ['required', 'integer', 'min:0'],
        ];
    }

    protected function messages() 
    {
        return [
            'componente_id.required' => 'El campo :attribute es requerido.',
            'componente_id.exists' => 'Selecciona una opción valida para el campo :attribute.',
            'componente_id.unique' => 'Ya existe un item con el mismo componente en esta compañia.',
        ];
    }

    public function guardar()
    {
        $this->validate();

        try {

            Item::create([
                'componente_id'        => $this->componente_id,
                'cantidad_operativo'   => $this->cantidad_operativo,
                'cantidad_inoperativo' => $this->cantidad_inoperativo,
                'compania_id'          => $this->compania_id,
                'creadoPor'            => Auth::id(),
            ]);

            session()->flash('success', 'MATERIAL MENOR CREADO CORRECTAMENTE');
        } catch (\Exception $e) {
            session()->flash(
                'error',
                'NO SE PUDO CREAR - ' . $e->getMessage()
            );
        }
        $this->reset(['componente_id', 'cantidad_operativo', 'cantidad_inoperativo']);
        return redirect()->route('materiales.menor.ver-compania', $this->compania_id);
    }

    public function render()
    {
        $this->dispatch('ver-form-alta'); # EMITE EVENTO QUE ESCUCHA COMPONENTE PADRE PARA ACTIVAR LOS SlimSelect
        return view('livewire.materiales.menor.menor.create');
    }
}
