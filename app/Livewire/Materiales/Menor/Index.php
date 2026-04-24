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

    public $paginadoMenor, $paginadoForestales, $paginadoEras;

    # PROPIEDADES PARA LOS SELECTS
    #public $departamentos = [], $ciudades = [], $regiones = [];

    public function mount()
    {
        $paginadoDefault = Auth::user()->paginado_por_defecto;

        $this->paginadoMenor      = $paginadoDefault;
        $this->paginadoForestales = $paginadoDefault;
        $this->paginadoEras       = $paginadoDefault;
    }

    public function render()
    {
        return view('livewire.materiales.menor.index', [
            'menor' => $this->queryBase()->menor()->paginate($this->paginadoMenor, [''], 'paginado-menor'),
            'forestales' => $this->queryBase()->forestales()->get(),
            'eras' => $this->queryBase()->eras()->get()
        ]);
    }

    public function queryBase()
    {
        return Item::select('componente_id', 'cantidad_operativo', 'cantidad_inoperativo', 'compania_id', 'marca_id')
            ->with([
                'componente:id_menor_componente,nombre,categoria_id',
                'componente.categoria:id_menor_categoria,nombre',
                'compania:id_compania,compania',
                'marca:id_menor_marca,nombre',
            ]);
    }
}
