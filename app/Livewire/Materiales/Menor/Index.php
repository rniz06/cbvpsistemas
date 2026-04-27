<?php

namespace App\Livewire\Materiales\Menor;

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
    #public $buscador = '', $buscarCompania = '', $buscarDepartamentoId = '', $buscarCiudadId = '', $buscarRegionId = '', $paginado;

    public $paginadoMenor, $paginadoForestales;

    # PROPIEDADES PARA LOS SELECTS
    #public $departamentos = [], $ciudades = [], $regiones = [];

     # PROPIEDAD PARA PASAR AL MODAL EDIT
    public $item = null;

    public function mount()
    {
        $paginadoDefault = Auth::user()->paginado_por_defecto;

        $this->paginadoMenor      = $paginadoDefault;
        $this->paginadoForestales = $paginadoDefault;
    }

    public function render()
    {
        return view('livewire.materiales.menor.index', [
            'menor' => $this->queryBase()->menor()->paginate($this->paginadoMenor, [''], 'paginado-menor'),
            'forestales' => $this->queryBase()->forestales()->paginate($this->paginadoForestales, [''], 'paginado-forestales'),
        ]);
    }

    public function queryBase()
    {
        return Item::select('id_menor_item','componente_id', 'cantidad_operativo', 'cantidad_inoperativo', 'compania_id', 'marca_id')
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
