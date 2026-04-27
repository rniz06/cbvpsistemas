<?php

namespace App\Livewire\Materiales\Menor;

use App\Enums\Materiales\Menor\TipoMenor;
use App\Models\Gral\Compania;
use App\Models\Materiales\Menor\Item;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class VerCompania extends Component
{
    /*
    |------------------------------------------------------
    | RENDERIZA VISTA DE UNA COMPANIA CON LISTA DE MAT. MENOR
    |------------------------------------------------------
    */

    use WithPagination;

    # COMPANIA A VER - CONDICIONAL PARA FORM ALTA - CONDICIONAL PARA FORM EDICION - ID DEL ITEM A EDITAR
    public $compania, $ver_form_alta = false, $ver_form_edicion = false, $item_id = null;

    # PAGINACION
    public $paginadoMenor, $paginadoForestales;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount(Compania $compania)
    {
        $this->compania           = $compania;
        $paginado                 = Auth::user()->paginado_por_defecto ?? 5;
        $this->paginadoMenor      = $paginado;
        $this->paginadoForestales = $paginado;
    }

    # LIMPIAR EL BUSCADOR Y LA PAGINACION AL CAMBIAR DE PAGINA
    public function updating($key): void
    {
        if (in_array($key, [
            'paginadoMenor',
            'paginadoForestales'
        ])) {
            $this->resetPage('paginadoMenor');
            $this->resetPage('paginadoForestales');
        }
    }

    public function render()
    {
        return view('livewire.materiales.menor.ver-compania', [
            'menor' => $this->queryBase()->menor()->paginate($this->paginadoMenor, [''], 'paginado-menor'),
            'forestales' => $this->queryBase()->forestales()->paginate($this->paginadoForestales, [''], 'paginado-forestales'),
        ]);
    }

    # QUERY BASE
    public function queryBase()
    {
        return Item::select('id_menor_item', 'componente_id', 'cantidad_operativo', 'cantidad_inoperativo')
            ->where('compania_id', $this->compania->id_compania)
            ->with([
                'componente:id_menor_componente,nombre,categoria_id',
                'componente.categoria:id_menor_categoria,nombre'
            ]);
    }

    public function form_edicion($item_id)
    {
        $this->item_id = $item_id;
        $this->ver_form_edicion = ! $this->ver_form_edicion;
    }

    public function form_edicion_cerrar()
    {
        $this->ver_form_edicion = ! $this->ver_form_edicion;
        $this->item_id = null;
    }
}
