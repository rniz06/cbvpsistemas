<?php

namespace App\Livewire\Materiales\Menor;

use App\Actions\Materiales\Menor\CrearComentarioItemAccion;
use App\Models\Materiales\Menor\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    /*
    |--------------------------------------------------------
    | COMPONENTE FORMULARIO DE ACTUALIZACION DE DATOS DE ITEM
    |--------------------------------------------------------
    */

    # COMPAÑIA A EDITAR
    public $registro;

    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $cantidad_operativo, $cantidad_inoperativo;

    public function mount(Item $item)
    {
        $this->registro  = $item; # REGISTRO ACTUAL

        # LLENAR PROPIEDADES DEL FORMULARIO
        $this->cantidad_operativo    = $item->cantidad_operativo;
        $this->cantidad_inoperativo  = $item->cantidad_inoperativo;
    }

    protected function rules()
    {
        return [
            'cantidad_operativo' => ['required', 'integer', 'min:0'],
            'cantidad_inoperativo' => ['required', 'integer', 'min:0'],
        ];
    }

    public function guardar(CrearComentarioItemAccion $action)
    {
        $this->validate();

        try {

            DB::transaction(function () use ($action) {
                $this->registro->update([
                    'cantidad_operativo'   => $this->cantidad_operativo,
                    'cantidad_inoperativo' => $this->cantidad_inoperativo,
                    'actualizadoPor'       => Auth::id(),
                ]);

                # REGISTRO DE COMENTARIO AUTOMATICO
                $action->execute($this->registro);
            });

            session()->flash('success', 'REGISTRO ACTUALIZADO CORRECTAMENTE');
        } catch (\Throwable $e) {
            report($e); // importante para logs reales

            session()->flash(
                'error',
                'NO SE PUDO ACTUALIZAR'
            );
        }

        return redirect()->route('materiales.menor.index');
    }

    public function render()
    {
        return view('livewire.materiales.menor.edit');
    }
}
