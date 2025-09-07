<?php

namespace App\Livewire\Personal\Comisionamientos;

use App\Exports\Excel\Personal\Comisionamientos\ExcelComisionamientosExport;
use App\Exports\ExcelGenericoExport;
use App\Exports\Pdf\Personal\Comisionamientos\ComisionamientosExport;
use App\Exports\PdfGenericoExport;
use App\Models\Admin\CompaniaGral;
use App\Models\Gral\Direccion;
use App\Models\Personal\Cargo;
use App\Models\Personal\Rango;
use App\Models\Vistas\Personal\VtComisionamiento;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    // Propiedad para los filtros
    public $companias = [], $cargos = [], $rangos = [], $direcciones = [];

    // Variables para la paginación y busqueda
    public $buscarNombreCompleto = '';
    public $buscarCodigo = '';
    public $buscarCargoId = '';
    public $buscarRangoId = '';
    public $buscarCompaniaId = '';
    public $buscarDireccionId = '';
    public $buscarCodigoComisionamiento = '';
    public $buscarCulminado = '';
    public $buscarFechaInicio = '';
    public $buscarFechaFin = '';
    public $paginado = 5;

    public $mostrarFormCulminarComi = false;
    public $comisionamiento_id_seleccionado = null;

    public function mount()
    {
        $this->companias   = CompaniaGral::select('id_compania', 'compania')->orderBy('orden')->get();
        $this->cargos      = Cargo::select('id_cargo', 'cargo')->orderBy('cargo')->get();
        $this->rangos      = Rango::select('id_rango', 'rango')->orderBy('rango')->get();
        $this->direcciones = Direccion::select('id_direccion', 'direccion')->orderBy('direccion')->get();
    }

    public function seleccionarComisionamientoParaCulminar($id)
    {
        $this->comisionamiento_id_seleccionado = $id;
        $this->mostrarFormCulminarComi = true;
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscarNombreCompleto',
            'buscarCodigo',
            'buscarCargoId',
            'buscarRangoId',
            'buscarCompaniaId',
            'buscarDireccionId',
            'buscarCodigoComisionamiento',
            'buscarCulminado',
            'buscarFechaInicio',
            'buscarFechaFin',
            'paginado',
        ])) {
            $this->resetPage('comisionados_page');
        }
    }

    public function render()
    {
        return view('livewire.personal.comisionamientos.index', [
            'comisionamientos' => VtComisionamiento::select(
                'id_comisionamiento',
                'nombrecompleto',
                'codigo',
                'cargo',
                'rango',
                'compania',
                'direccion',
                'codigo_comisionamiento',
                'culminado',
                'fecha_inicio',
                'fecha_fin'
            )
                ->buscarNombreCompleto($this->buscarNombreCompleto)
                ->buscarCodigo($this->buscarCodigo)
                ->buscarCargoId($this->buscarCargoId)
                ->buscarRangoId($this->buscarRangoId)
                ->buscarCompaniaId($this->buscarCompaniaId)
                ->buscarDireccionId($this->buscarDireccionId)
                ->buscarCodigoComisionamiento($this->buscarCodigoComisionamiento)
                ->buscarCulminado($this->buscarCulminado)
                ->buscarFechaInicio($this->buscarFechaInicio)
                ->buscarFechaFin($this->buscarFechaFin)
                ->paginate($this->paginado, ['*'], 'comisionados_page')
        ]);
    }

    // Obtener lo datos para los reportes pdf y excel
    public function cargarComisionamientosExport()
    {
        $query  = VtComisionamiento::select([
            DB::raw("CONCAT(nombrecompleto, ' - ', codigo) as nombre_codigo"),
            'cargo',
            'rango',
            'compania',
            'direccion',
            'codigo_comisionamiento',
            'culminado',
            'fecha_inicio',
            'fecha_fin',
        ])
            ->buscarNombreCompleto($this->buscarNombreCompleto)
            ->buscarCodigo($this->buscarCodigo)
            ->buscarCargoId($this->buscarCargoId)
            ->buscarRangoId($this->buscarRangoId)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->buscarDireccionId($this->buscarDireccionId)
            ->buscarCodigoComisionamiento($this->buscarCodigoComisionamiento)
            ->buscarCulminado($this->buscarCulminado)
            ->buscarFechaInicio($this->buscarFechaInicio)
            ->buscarFechaFin($this->buscarFechaFin)
            ->get();
            
        return $query;
    }


    public function excel()
    {
        $query = $this->cargarComisionamientosExport();
        //$encabezados = ['Nombre - Código', 'Cargo', 'Rango', 'Comisionado', 'En', 'Códido Rad.', 'Culminado', 'Fecha Inicio', 'Fecha Fin'];

        return Excel::download(new ExcelComisionamientosExport($query), 'Listado de Comisionamientos.xlsx');
    }

    public function pdf()
    {
        $query = $this->cargarComisionamientosExport();
        $nombre_archivo = "Listado de Comisionamientos";

        return (new ComisionamientosExport($query, $nombre_archivo))->download();
    }
}
