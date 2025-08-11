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
    public $cargos = [], $rangos = [], $companias = [], $direcciones = [];

    // Variables para la paginación y busqueda
    public $buscarNombreCompleto = '';
    public $buscarCodigo = '';
    public $buscarCargoId = '';
    public $buscarSufijo = '';
    public $buscarRangoId = '';
    public $buscarCompaniaId = '';
    public $buscarDireccionId = '';
    public $buscarFechaInicio = '';
    public $buscarCulminado = '';
    public $paginado = 5;

    public function mount()
    {
        $this->cargos      = Cargo::select('id_cargo', 'cargo')->orderBy('cargo')->get();
        $this->rangos      = Rango::select('id_rango', 'rango')->orderBy('rango')->get();
        $this->companias   = CompaniaGral::select('id_compania', 'compania')->orderBy('orden')->get();
        $this->direcciones = Direccion::select('id_direccion', 'direccion')->orderBy('direccion')->get();
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscarNombreCompleto',
            'buscarCodigo',
            'buscarCargoId',
            'buscarSufijo',
            'buscarRangoId',
            'buscarCompaniaId',
            'buscarDireccionId',
            'buscarFechaInicio',
            'buscarCulminado',
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
                'fecha_inicio',
                'resolucion_id',
                'cargo',
                'sufijo',
                'rango',
                'compania',
                'direccion',
                'culminado'
            )
                ->buscarNombreCompleto($this->buscarNombreCompleto)
                ->buscarCodigo($this->buscarCodigo)
                ->buscarFechaInicio($this->buscarFechaInicio)
                ->buscarCargoId($this->buscarCargoId)
                ->buscarSufijo($this->buscarSufijo)
                ->buscarRangoId($this->buscarRangoId)
                ->buscarCompaniaId($this->buscarCompaniaId)
                ->buscarDireccionId($this->buscarDireccionId)
                ->buscarCulminado($this->buscarCulminado)
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
        return VtComisionamiento::select(
            'nombrecompleto',
            'codigo',
            'fecha_inicio',
            'cargo',
            'sufijo',
            'rango',
            'compania',
            'direccion',
        )
            ->buscarNombreCompleto($this->buscarNombreCompleto)
            ->buscarCodigo($this->buscarCodigo)
            ->buscarFechaInicio($this->buscarFechaInicio)
            ->buscarCargoId($this->buscarCargoId)
            ->buscarSufijo($this->buscarSufijo)
            ->buscarRangoId($this->buscarRangoId)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->buscarDireccionId($this->buscarDireccionId)
            ->buscarCulminado($this->buscarCulminado)
            ->get();
    }


    public function excel()
    {
        $datos = $this->cargarComisionamientosExport();
        $encabezados = ['Nombre Completo', 'Código', 'Fecha De Inicio', 'Cargo', 'Sufijo', 'Rango', 'Comisionado a', 'En'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Listado de Comisionamientos.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Listado de Comisionamientos";
        $datos = $this->cargarComisionamientosExport();
        $encabezados = ['Nombre C.', 'Código', 'F. Inicio', 'Cargo', 'Sufijo', 'Rango', 'Comisionado a', 'En'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
