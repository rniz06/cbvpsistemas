<?php

namespace App\Livewire\Materiales\Menor\Menor;

use App\Enums\Materiales\Menor\CategoriaComponente;
use App\Exports\Excel\Materiales\Menor\Menor\ListadoMenorInoperativosExcel;
use App\Exports\Excel\Materiales\Menor\Menor\ListadoMenorOperativosExcel;
use App\Exports\Excel\Materiales\Menor\Menor\ListadoMenorResumenExcel;
use App\Exports\Pdf\Materiales\Menor\Menor\ListaMenorInoperativosPdf;
use App\Exports\Pdf\Materiales\Menor\Menor\ListaMenorOperativosPdf;
use App\Exports\Pdf\Materiales\Menor\Menor\ListaMenorResumenPdf;
use App\Models\Gral\Compania;
use App\Models\Materiales\Menor\Componente;
use App\Models\Materiales\Menor\Item;
use App\Models\Materiales\Menor\Marca;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

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
        return view('livewire.materiales.menor.menor.index', [
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
