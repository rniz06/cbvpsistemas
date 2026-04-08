<?php

namespace App\Livewire\Materiales\Menor\Menor;

use App\Enums\Materiales\Menor\CategoriaComponente;
use App\Models\Gral\Compania;
use App\Models\Materiales\Menor\Componente;
use App\Models\Materiales\Menor\Item;
use App\Models\Materiales\Menor\Marca;
use App\Models\Materiales\Operatividad;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    /*
    |------------------------------------------------------
    | RENDERIZA VISTA INDEX DE MATERIAL MENOR
    |------------------------------------------------------
    */
    use WithPagination;

    # PROPIEDADES DE BUSQUEDA Y PAGINACION
    public $buscarComponenteId = '', $buscarMarcaId = '', $buscarCompaniaId = '';
    public $paginadoOperativo, $paginadoInoperativo, $paginadoResumen;

    # PROPIEDADES PARA LOS SELECTS
    //public $componentes = [], $marcas = [], $companias = [];

    # FUNCION MOUNT DE LIVEWIRE
    public function mount()
    {
        $paginado = Auth::user()->paginado_por_defecto ?? 5;

        $this->paginadoOperativo   = $paginado;
        $this->paginadoInoperativo = $paginado;
        $this->paginadoResumen     = $paginado;

        // $this->componentes = Componente::select('id_menor_componente', 'nombre', 'marca_id')
        //     ->where('categoria_id', CategoriaComponente::MATERIAL_MENOR) # FILTRADO POR MATERIAL MENOR
        //     ->with('marca:id_menor_marca,nombre')
        //     ->orderBy('nombre')
        //     ->get();

        // $this->marcas    = Marca::get(['id_menor_marca', 'nombre']);
        // $this->companias = Compania::filtrarPorRolMateriales()->orderBy('orden')->get(['id_compania', 'compania']);
    }

    # LIMPIAR EL BUSCADOR Y LA PAGINACION AL CAMBIAR DE PAGINA
    public function updating($key): void
    {
        if (in_array($key, [
            'buscarComponenteId',
            'buscarMarcaId',
            'buscarCompaniaId',
            'paginadoOperativo',
            'paginadoInoperativo',
            'paginadoResumen',
        ])) {
            $this->resetPage('operativos-page');
            $this->resetPage('inoperativos-page');
            $this->resetPage('resumen-page');
        }
    }

    public function render()
    {
        return view('livewire.materiales.menor.menor.index', [
            'operativos' => $this->queryBase()
                ->operativos()
                ->paginate($this->paginadoOperativo, [''], 'operativos-page'),
            'inoperativos' => $this->queryBase()
                ->inoperativos()
                ->paginate($this->paginadoInoperativo, [''], 'inoperativos-page'),
            'resumen' => 'aaa',
        ]);
    }

    # QUERY BASE PARA OPERATIVOS E INOPERATIVOS
    public function queryBase()
    {
        return Item::select('id_menor_item', 'componente_id', 'estado_id', 'compania_id')
            ->filtrarPorRolMateriales()
            ->buscarComponenteId($this->buscarComponenteId)
            ->buscarMarcaId($this->buscarMarcaId)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->with([
                'componente:id_menor_componente,nombre,marca_id,categoria_id',
                'componente.marca:id_menor_marca,nombre',
                'estado:id_operatividad,operatividad',
                'compania:id_compania,compania'
            ])
            ->whereRelation('componente', 'categoria_id', CategoriaComponente::MATERIAL_MENOR);
    }

    /*
    |-------------------------------------------------------------
    | FUNCIONES/PROPIEDADES DEFINIDAS PARA LOS FILTROS DE BUSQUEDA
    |-------------------------------------------------------------
    */

    public function getComponentesProperty()
    {
        return Componente::select('id_menor_componente', 'nombre', 'marca_id')
            ->where('categoria_id', CategoriaComponente::MATERIAL_MENOR)
            ->orderBy('nombre')
            ->get();
    }

    public function getMarcasProperty()
    {
        return Marca::select('id_menor_marca', 'nombre')->get();
    }

    public function getCompaniasProperty()
    {
        return Compania::filtrarPorRolMateriales()
            ->orderBy('orden')
            ->get(['id_compania', 'compania']);
    }
}
