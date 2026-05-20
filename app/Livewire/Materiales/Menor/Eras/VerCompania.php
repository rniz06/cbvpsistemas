<?php

namespace App\Livewire\Materiales\Menor\Eras;

use App\Enums\Materiales\Menor\TipoMenor;
use App\Models\Gral\Compania;
use App\Models\Materiales\Menor\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class VerCompania extends Component
{
    /*
    |------------------------------------------------------
    | RENDERIZA VISTA DE UNA COMPANIA CON LISTA DE ERAS
    |------------------------------------------------------
    */

    use WithPagination;

    # COMPANIA A VER - CONDICIONAL PARA FORM ALTA - CONDICIONAL PARA FORM EDICION - ID DEL ITEM A EDITAR
    public $compania, $ver_form_alta = false, $ver_form_edicion = false, $item = null, $paginado;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount(Compania $compania)
    {
        $this->compania           = $compania;
        $this->paginado           = Auth::user()->paginado_por_defecto ?? 10;
    }

    # LIMPIAR EL BUSCADOR Y LA PAGINACION AL CAMBIAR DE PAGINA
    public function updating($key): void
    {
        if (in_array($key, [
            'paginado',
        ])) {
            $this->resetPage('paginado-eras');
        }
    }

    public function render()
    {
        return view('livewire.materiales.menor.eras.ver-compania', [
            'eras' => $this->queryBase()->paginate($this->paginado, [''], 'paginado-eras'),
        ]);
    }

    # QUERY BASE
    public function queryBase()
    {
        return Item::select('id_menor_item', 'componente_id', 'cantidad_operativo', 'cantidad_inoperativo', DB::raw('(cantidad_operativo + cantidad_inoperativo) AS cantidad_total'), 'marca_id')
            ->eras()
            ->where('compania_id', $this->compania->id_compania)
            ->with([
                'componente:id_menor_componente,nombre,categoria_id',
                'marca:id_menor_marca,nombre'
            ]);
    }

    public function abrirModalEdit($item)
    {
        $this->item = $item;
    }

    public function abrirModalVerComentarios($item)
    {
        $this->item = $item;
    }
}
