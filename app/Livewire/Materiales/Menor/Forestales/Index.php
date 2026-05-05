<?php

namespace App\Livewire\Materiales\Menor\Forestales;

use App\Models\Gral\Compania;
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
    public $buscarIdCompania = '', $paginado;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount()
    {
        $this->paginado = Auth::user()->paginado_por_defecto ?? 5;
    }

    # LIMPIAR EL BUSCADOR Y LA PAGINACION AL CAMBIAR DE PAGINA
    public function updating($key): void
    {
        if (in_array($key, [
            'buscarIdCompania',
            'paginado',
        ])) {
            $this->resetPage('companias-page');
        }
    }

    public function render()
    {
        return view('livewire.materiales.menor.forestales.index', [
            'companias' => $this->queryBase()->paginate($this->paginado, [''], 'companias-page'),
        ]);
    }

    # QUERY BASE
    public function queryBase()
    {
        return Compania::select('id_compania', 'compania')->filtrarPorRolMateriales()
            ->buscarIdCompania($this->buscarIdCompania);
    }

    /*
    |-------------------------------------------------------------
    | FUNCIONES/PROPIEDADES DEFINIDAS PARA LOS FILTROS DE BUSQUEDA
    |-------------------------------------------------------------
    */

    public function getCompaniasProperty()
    {
        return Compania::filtrarPorRolMateriales()
            ->orderBy('orden')
            ->get(['id_compania', 'compania']);
    }
}
