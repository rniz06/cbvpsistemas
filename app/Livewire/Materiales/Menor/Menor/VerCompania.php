<?php

namespace App\Livewire\Materiales\Menor\Menor;

use App\Enums\Materiales\Menor\CategoriaComponente;
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

    # COMPANIA A VER - PAGINACION - CONDICIONAL PARA FORM ALTA
    public $compania, $paginado, $ver_form_alta = false;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount(Compania $compania)
    {
        $this->compania = $compania;
        $this->paginado       = Auth::user()->paginado_por_defecto ?? 5;
    }

    # LIMPIAR EL BUSCADOR Y LA PAGINACION AL CAMBIAR DE PAGINA
    public function updating($key): void
    {
        if (in_array($key, [
            'paginado',
        ])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.materiales.menor.menor.ver-compania', [
            'items' =>$this->queryBase()->paginate($this->paginado)
        ]);
    }

    # QUERY BASE
    public function queryBase()
    {
        return Item::select('id_menor_item', 'componente_id', 'cantidad_operativo', 'cantidad_inoperativo')
            ->where('compania_id', $this->compania->id_compania)
            ->with(['componente:id_menor_componente,nombre,categoria_id'])
            ->whereRelation('componente', 'categoria_id', CategoriaComponente::MATERIAL_MENOR);
    }
}
