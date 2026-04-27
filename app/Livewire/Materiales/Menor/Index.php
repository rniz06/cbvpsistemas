<?php

namespace App\Livewire\Materiales\Menor;

use App\Enums\Materiales\Menor\TipoMenor;
use App\Models\Gral\Compania;
use App\Models\Materiales\Menor\Categoria;
use App\Models\Materiales\Menor\Componente;
use App\Models\Materiales\Menor\Item;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    /*
    |----------------------------------------------------
    | INDEX DE MATERIAL MENOR
    |----------------------------------------------------
    */

    use WithPagination;

    # PROPIEDADES DE BUSQUEDA Y PAGINACION
    public $buscarComponenteId = '', $buscarCategoriaId = '', $buscarCompaniaId = '';

    public $paginadoMenor, $paginadoForestales;

    # PROPIEDADES PARA LOS SELECTS
    public $componentes = [], $categorias = [], $companias = [];

    # PROPIEDAD PARA PASAR AL MODAL EDIT
    public $item = null;

    public function mount()
    {
        $paginadoDefault = Auth::user()->paginado_por_defecto;

        $this->paginadoMenor      = $paginadoDefault;
        $this->paginadoForestales = $paginadoDefault;

        $this->componentes = Componente::whereIn('tipo_id', [
            TipoMenor::MENOR->value,
            TipoMenor::FORESTALES->value
        ])->get(['id_menor_componente', 'nombre']);

        $this->categorias = Categoria::get(['id_menor_categoria', 'nombre']);
        $this->companias  = Compania::filtrarPorRolMateriales()->get(['id_compania', 'compania']);
    }

    public function render()
    {
        return view('livewire.materiales.menor.index', [
            'menor' => $this->queryBase()->menor()->buscarCategoriaId($this->buscarCategoriaId)->paginate($this->paginadoMenor, [''], 'paginado-menor'),
            'forestales' => $this->queryBase()->forestales()->paginate($this->paginadoForestales, [''], 'paginado-forestales'),
        ]);
    }

    public function queryBase()
    {
        return Item::select('id_menor_item', 'componente_id', 'cantidad_operativo', 'cantidad_inoperativo', 'compania_id', 'marca_id')
            ->buscarComponenteId($this->buscarComponenteId)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->with([
                'componente:id_menor_componente,nombre,categoria_id',
                'componente.categoria:id_menor_categoria,nombre',
                'compania:id_compania,compania',
                'marca:id_menor_marca,nombre',
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
