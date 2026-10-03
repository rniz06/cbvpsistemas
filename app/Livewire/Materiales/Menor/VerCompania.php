<?php

namespace App\Livewire\Materiales\Menor;

use App\Enums\Materiales\Menor\TipoMenor;
use App\Models\Gral\Compania;
use App\Models\Materiales\Menor\Categoria;
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
    public $compania, $ver_form_alta = false, $ver_form_edicion = false, $item = null, $paginado;

    # PROPIEDAD DE BUSQUEDA Y SELECT
    public $buscarCategoriaId = '', $categorias = [];

    # FUNCION MOUNT DE LIVEWIRE
    public function mount(Compania $compania)
    {
        $this->compania           = $compania;
        $this->categorias         = Categoria::menor()->get(['id_menor_categoria', 'nombre']);
        $this->paginado           = Auth::user()->paginado_por_defecto ?? 5;
    }

    # LIMPIAR EL BUSCADOR Y LA PAGINACION AL CAMBIAR DE PAGINA
    public function updating($key): void
    {
        if (in_array($key, [
            'paginado',
        ])) {
            $this->resetPage('paginadoMenor');
        }
    }

    public function render()
    {
        return view('livewire.materiales.menor.ver-compania', [
            'menor' => $this->queryBase()->paginate($this->paginado, [''], 'paginado-menor'),
        ]);
    }

    # QUERY BASE
    public function queryBase()
    {
        return Item::select('id_menor_item', 'componente_id', 'cantidad_operativo', 'cantidad_inoperativo')
            ->menor()
            ->where('compania_id', $this->compania->id_compania)
            ->buscarCategoriaId($this->buscarCategoriaId)
            ->with([
                'componente:id_menor_componente,nombre,categoria_id',
                'componente.categoria:id_menor_categoria,nombre'
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
