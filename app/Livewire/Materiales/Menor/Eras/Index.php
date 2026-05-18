<?php

namespace App\Livewire\Materiales\Menor\Eras;

use App\Enums\Materiales\Menor\TipoMenor;
use App\Models\Gral\Compania;
use App\Models\Materiales\Menor\Categoria;
use App\Models\Materiales\Menor\Componente;
use App\Models\Materiales\Menor\Item;
use App\Models\Materiales\Menor\Marca;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public $buscarComponenteId = '', $buscarMarcaId = '', $buscarCompaniaId = '', $paginado;

    # PROPIEDADES PARA LOS SELECTS
    public $componentes = [], $marcas = [], $companias = [];

    # PROPIEDAD PARA PASAR AL MODAL EDIT
    public $item = null;

    public function mount()
    {
        $this->paginado = Auth::user()->paginado_por_defecto;

        $this->componentes = Componente::where('tipo_id', TipoMenor::ERAS->value)
            ->get(['id_menor_componente', 'nombre']);
        $this->companias  = Compania::filtrarPorRolMateriales()->get(['id_compania', 'compania']);
        $this->marcas  = Marca::orderBy('nombre')->get(['id_menor_marca', 'nombre']);
    }

    public function render()
    {
        return view('livewire.materiales.menor.eras.index', [
            'eras' => $this->queryBase()->paginate($this->paginado, [''], 'paginado-eras'),
        ]);
    }

    public function queryBase()
    {
        return Item::select('id_menor_item', 'componente_id', 'cantidad_operativo', 'cantidad_inoperativo', 'compania_id', 'marca_id', DB::raw('(cantidad_operativo + cantidad_inoperativo) AS cantidad_total'))
            ->eras()
            ->buscarComponenteId($this->buscarComponenteId)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->buscarMarcaId($this->buscarMarcaId)
            ->filtrarPorRolMateriales()
            ->with([
                'componente:id_menor_componente,nombre',
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
