<?php

namespace App\Livewire\Personal\Comisionamientos;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Admin\CompaniaGral;
use App\Models\Gral\Direccion;
use App\Models\Personal\Cargo;
use App\Models\Personal\Comisionamiento;
use App\Models\Personal\Rango;
use App\Models\Vistas\Personal\VtComisionamiento;
use Carbon\Carbon;
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

    public function mount()
    {
        $this->companias   = CompaniaGral::select('id_compania', 'compania')->orderBy('orden')->get();
        $this->cargos      = Cargo::select('id_cargo', 'cargo')->orderBy('cargo')->get();
        $this->rangos      = Rango::select('id_rango', 'rango')->orderBy('rango')->get();
        $this->direcciones = Direccion::select('id_direccion', 'direccion')->orderBy('direccion')->get();
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

    public function culminar($id)
    {
        $comisionamiento = Comisionamiento::findOrFail($id);
        $comisionamiento->update([
            'fecha_fin' => now(),
            'culminado' => 1 // True
        ]);
        session()->flash('success', 'Comisionamiento Culminado Exitosamente!');
        return redirect()->route('personal.comisionamientos.index');
    }

    // Obtener lo datos para los reportes pdf y excel
    public function cargarComisionamientosExport()
    {
        return VtComisionamiento::select([
            'nombrecompleto',
            'codigo',
            'compania',
            'fecha_inicio',
            'fecha_fin',
            'codigo_comisionamiento',
            'culminado',
        ])
            ->buscarNombreCompleto($this->buscarNombreCompleto)
            ->buscarCodigo($this->buscarCodigo)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->buscarFechaInicio($this->buscarFechaInicio)
            ->buscarFechaFin($this->buscarFechaFin)
            ->buscarCodigoComisionamiento($this->buscarCodigoComisionamiento)
            ->buscarCulminado($this->buscarCulminado)
            ->get();
    }


    public function excel()
    {
        $datos = $this->cargarComisionamientosExport();
        $encabezados = ['Nombre C.', 'Código', 'Comisionado a', 'F. Inicio', 'F. Fin', 'Códido Com.', 'Culminado'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Listado de Comisionamientos.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Listado de Comisionamientos";
        $datos = $this->cargarComisionamientosExport();
        $encabezados = ['Nombre C.', 'Código', 'Comisionado a', 'F. Inicio', 'F. Fin', 'Códido Com.', 'Culminado'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
