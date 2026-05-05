<?php

namespace App\Livewire\Materiales\Menor\Forestales;

use App\Models\Materiales\Menor\Item;
use App\Models\Materiales\Menor\ItemComentario;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class VerFicha extends Component
{
    /*
    |--------------------------------------------------------------
    | RENDERIZA VISTA DE FICHA DE MATERIAL MENOR Y SUS COMENTARIOS
    |--------------------------------------------------------------
    */

    use WithPagination;

    # REGISTRO ACTUAL | PAGINACION | CONDICIONAL PARA FORM ALTA COMENTARIO
    public $item, $paginado, $ver_form_alta = false;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount(Item $item)
    {
        $this->paginado = Auth::user()->paginado_por_defecto ?? 5;
        $this->item     = $item;
    }

    public function render()
    {
        return view('livewire.materiales.menor.forestales.ver-ficha', [
            'comentarios' => $this->queryBase()->paginate($this->paginado)
        ]);
    }

    public function queryBase()
    {
        return ItemComentario::select('idmenor_item_comentario', 'comentario', 'accion_id', 'creadoPor', 'created_at')
            ->where('item_id', $this->item->id_menor_item)
            ->with([
                'creadoPor:id_usuario,nombrecompleto',
                'accion:id_accion,accion'
            ])
            ->orderByDesc('created_at');
    }

}
