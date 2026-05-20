<?php

namespace App\Livewire\Materiales\Menor\Eras;

use App\Enums\Materiales\Menor\TipoMenor;
use App\Models\Gral\Compania;
use App\Models\Materiales\Menor\Item;
use App\Models\Materiales\Menor\Marca;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    /*
    |----------------------------------------------------
    | INDEX DE ERAS
    |----------------------------------------------------
    */

    use WithPagination;

    # PROPIEDADES DE BUSQUEDA Y PAGINACION
    public ?int $bucarMarcaId = null, $buscarCompaniaId = null, $paginado;

    # PROPIEDADES PARA LOS SELECTS
    public array $marcas = [], $companias = [];

    public function mount()
    {
        $this->paginado = Auth::user()->paginado_por_defecto ?? 5;
        $this->marcas = Marca::orderBy('nombre')
            ->pluck('nombre', 'id_menor_marca')
            ->toArray();

        $this->companias = Compania::filtrarPorRolMateriales()
            ->orderBy('orden')
            ->pluck('compania', 'id_compania')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.materiales.menor.eras.index', [
            'eras' => $this->queryBase()->paginate($this->paginado, [''], 'paginado-eras'),
        ]);
    }

    public function queryBase()
    {
        return Item::eras()->select(
            'id_menor_item',
            'cantidad_operativo',
            'cantidad_inoperativo',
            DB::raw('(cantidad_operativo + cantidad_inoperativo) AS cantidad_total'),
            'compania_id',
            'marca_id'
        )
            ->with([
                'compania:id_compania,compania',
                'marca:id_menor_marca,nombre'
            ])
            ->buscarMarcaId($this->bucarMarcaId)
            ->buscarCompaniaId($this->buscarCompaniaId);
        //->groupBy('marca_id');
    }
}
