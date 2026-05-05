<?php

namespace App\Livewire\Materiales\Menor\Forestales;

use App\Actions\Materiales\Menor\AplicarAccionItem;
use App\Models\Materiales\Accion;
use App\Models\Materiales\Menor\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateComentario extends Component
{
    /*
    |------------------------------------------------------
    | RENDERIZA FORM DE ALTA DE COMENTARIO PARA FORESTALES
    / EN materiales.menor.forestales.ver-ficha
    |------------------------------------------------------
    */

    # REGISTRO ACTUAL
    public $item;

    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $accion_id, $comentario;

    public function mount(Item $item)
    {
        $this->item = $item;
    }

    protected function rules()
    {
        return [
            'accion_id'  => ['required', Rule::exists(Accion::class, 'id_accion')],
            'comentario' => ['required', 'max:65535']
        ];
    }

    public function guardar(AplicarAccionItem $action)
    {
        $this->validate();

        try {

            DB::transaction(function () use ($action) {
                $this->item->comentarios()->create([
                    'accion_id'  => $this->accion_id,
                    'comentario' => $this->comentario,
                    'creadoPor'  => Auth::id(),
                ]);
                # APLICAR LA ACCION
                $action->handle($this->accion_id, $this->item->id_menor_item);
            });

            session()->flash('success', 'COMENTARIO CREADO CORRECTAMENTE');
        } catch (\Exception $e) {
            session()->flash(
                'error',
                'NO SE PUDO CREAR - ' . $e->getMessage()
            );
        }
        return redirect()->route('materiales.menor.forestales.ver-ficha', $this->item->id_menor_item);
    }

    public function render()
    {
        return view('livewire.materiales.menor.forestales.create-comentario');
    }
}
