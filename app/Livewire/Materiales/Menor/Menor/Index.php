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
    public $buscarComponenteId = '', $buscarMarcaId = '', $buscarCompaniaId = '';
    public $paginadoOperativo, $paginadoInoperativo, $paginadoResumen;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount()
    {
        $paginado = Auth::user()->paginado_por_defecto ?? 5;

        $this->paginadoOperativo   = $paginado;
        $this->paginadoInoperativo = $paginado;
        $this->paginadoResumen     = $paginado;
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
            'resumen' => $this->queryResumen()->paginate($this->paginadoResumen, [''], 'resumen-page'),
        ]);
    }

    # QUERY BASE
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

    public function queryResumen()
    {
        # TRAE CAMPOS NOMBRE, MARCA, ESTADO Y PINTARLOS ASI:
        # nombre, marca, operativo, inoperativo
        # Manga,  ucsa,  10,        12
        # Piton,  ucsa,  5,         8 
        return $this->queryBase()->join('MAT_menor_componentes as c', 'c.id_menor_componente', '=', 'MAT_menor_items.componente_id')
            ->join('MAT_menor_marcas as m', 'm.id_menor_marca', '=', 'c.marca_id')
            ->select(
                'c.nombre as componente',
                'm.nombre as marca',
                DB::raw('SUM(CASE WHEN MAT_menor_items.estado_id = 1 THEN 1 ELSE 0 END) as operativos'),
                DB::raw('SUM(CASE WHEN MAT_menor_items.estado_id = 0 THEN 1 ELSE 0 END) as inoperativos')
            )
            ->groupBy('c.nombre', 'm.nombre')
            ->orderBy('c.nombre');
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

    /*
    |-------------------------------------------------------------
    | FUNCIONES DE EXPORTACION DE DATOS
    |-------------------------------------------------------------
    */

    public function exportar($formatoExportacion)
    {
        return match ($formatoExportacion) {
            'excelOperativos' => Excel::download(new ListadoMenorOperativosExcel($this->queryBase()->operativos()->get()), 'Menor Operativos.xlsx'),
            'excelInoperativos' => Excel::download(new ListadoMenorInoperativosExcel($this->queryBase()->inoperativos()->get()), 'Menor Inoperativos.xlsx'),
            'excelResumen' => Excel::download(new ListadoMenorResumenExcel($this->queryResumen()->get()), 'Menor Resumen.xlsx'),
            'pdfOperativos' => (new ListaMenorOperativosPdf($this->queryBase()->operativos()->get(), 'Menor Operativos'))->download(),
            'pdfInoperativos' => (new ListaMenorInoperativosPdf($this->queryBase()->inoperativos()->get(), 'Menor Inoperativos'))->download(),
            'pdfResumen' => (new ListaMenorResumenPdf($this->queryResumen()->get(), 'Menor Resumen'))->download(),
        };
    }
}
