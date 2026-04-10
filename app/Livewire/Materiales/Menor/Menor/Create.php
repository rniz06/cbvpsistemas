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
    public $componente_id, $marca_id, $compania_id;

    # PROPIEDADES DE LOS SELECTS
    public $componentes, $marcas;

    public function mount(int $companiaId)
    {
        $this->componentes  = Componente::menor()->get(['id_menor_componente', 'nombre']);
        $this->marcas       = Marca::get(['id_menor_marca', 'nombre']);
        $this->compania_id  = $companiaId; # ID DE COMPANIA RECIBIDA
    }

    protected function rules()
    {
        return [
            'componente_id'  => ['required', Rule::exists(Componente::class, 'id_menor_componente')],
            'marca_id'       => ['required', 'integer', Rule::exists(Marca::class, 'id_menor_marca')],
        ];
    }

    public function guardar()
    {
        $this->validate();

        try {

            Item::create([
                'componente_id' => $this->componente_id,
                'marca_id'      => $this->marca_id,
                'estado_id'     => 1, # OPERATIVO POR DEFECTO
                'compania_id'   => $this->compania_id,
                'creadoPor'     => Auth::id(),
            ]);

            session()->flash('success', 'MATERIAL MENOR CREADO CORRECTAMENTE');
        } catch (\Exception $e) {
            session()->flash(
                'error',
                'NO SE PUDO CREAR - ' . $e->getMessage()
            );
        }
        $this->reset(['componente_id', 'marca_id']);
        return redirect()->route('materiales.menor.ver-compania', $this->compania_id);
    }

    public function render()
    {
        $this->dispatch('ver-form-alta'); # EMITE EVENTO QUE ESCUCHA COMPONENTE PADRE PARA ACTIVAR LOS SlimSelect
        return view('livewire.materiales.menor.menor.create');
    }
}
