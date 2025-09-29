<?php

namespace App\Livewire\Cca\Reportes;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Admin\CompaniaGral;
use App\Models\Cca\Servicios\Clasificacion;
use App\Models\Cca\Servicios\Servicio;
use App\Models\Vistas\Cca\VtExistente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Historico extends Component
{
    use WithPagination;

    // Propiedades para el filtro de reportes
    public $fecha_desde;
    public $fecha_hasta;
    public $compania_id;
    public $servicio_id;
    public $clasificacion_id;

    // Propiedades para los selects
    public $companias;
    public $servicios;
    public $clasificaciones;

    public $buscador = '';
    public $paginado = 15;

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscador',
            'paginado',
            'fecha_desde',
            'fecha_hasta',
            'compania_id',
            'servicio_id',
            'clasificacion_id',
        ])) {
            $this->resetPage('historicos_page');
        }
    }

    public function mount()
    {
        $this->fecha_desde = Carbon::now()->toDateString();
        $this->fecha_hasta = Carbon::now()->toDateString();
        $this->companias = CompaniaGral::select('id_compania', 'compania')->orderBy('orden')->get();
        $this->servicios = Servicio::select('id_servicio', 'servicio')->get();
        $this->clasificaciones = Clasificacion::select('id_servicio_clasificacion', 'clasificacion', 'servicio_id')
            ->where('servicio_id', $this->servicio_id)
            ->get();
    }

    // Método para actualizar las clasificaciones al seleccionar un servicio
    public function updatedServicioId($value)
    {
        $this->clasificaciones = Clasificacion::select('id_servicio_clasificacion', 'clasificacion', 'servicio_id')
            ->when($value, function ($query) use ($value) {
                return $query->where('servicio_id', $value);
            })
            ->get();
        $this->clasificacion_id = null;
    }

    public function render()
    {
        return view('livewire.cca.reportes.historico', [
            'historicos' => VtExistente::select('id_servicio_existente', 'compania', 'servicio', 'clasificacion', 'tipo', 'movil', 'acargo', 'acargo_codigo', 'acargo_nombrecompleto', 'acargo_aux', 'acargo_codigo_comisionamiento', 'chofer', 'chofer_codigo', 'chofer_categoria', 'cantidad_tripulantes', 'fecha_alfa')
                ->where('estado_id', 4) // Servicio Culminado
                ->when($this->fecha_desde, function ($query) {
                    return $query->whereDate('fecha_alfa', '>=', $this->fecha_desde);
                })
                ->when($this->fecha_hasta, function ($query) {
                    return $query->whereDate('fecha_alfa', '<=', $this->fecha_hasta);
                })
                ->when($this->compania_id, function ($query) {
                    return $query->where('compania_id', $this->compania_id);
                })
                ->when($this->servicio_id, function ($query) {
                    return $query->where('servicio_id', $this->servicio_id);
                })
                ->when($this->clasificacion_id, function ($query) {
                    return $query->where('clasificacion_id', $this->clasificacion_id);
                })
                ->orderByDesc('fecha_alfa')
                ->paginate($this->paginado, ['*'], 'historicos_page'),
        ]);
    }

    public function cargarDatosExport()
    {
        return VtExistente::select(
            'compania',
            'servicio',
            'clasificacion',
            DB::raw("CONCAT(tipo, '-', movil) AS tipo_movil"),

            // Acargo: si es null usar acargo_aux
            DB::raw("
        CASE 
            WHEN acargo_nombrecompleto IS NULL THEN acargo_aux
            ELSE CONCAT(acargo_nombrecompleto, '-', acargo_codigo, '-', acargo_categoria)
        END AS acargo
    "),

            // Chofer: condiciones según chofer_rentado
            DB::raw("
        CASE 
            WHEN chofer_rentado = 1 THEN 'RENTADO'
            WHEN chofer_rentado = 0 AND chofer_nombrecompleto IS NOT NULL AND chofer_codigo IS NOT NULL 
                THEN CONCAT(chofer_nombrecompleto, '-', chofer_codigo)
            ELSE chofer_aux
        END AS chofer
    "),

            'cantidad_tripulantes',
            'fecha_alfa'
        )
            ->where('estado_id', 4) // Servicio Culminado
            ->when($this->fecha_desde, function ($query) {
                return $query->whereDate('fecha_alfa', '>=', $this->fecha_desde);
            })
            ->when($this->fecha_hasta, function ($query) {
                return $query->whereDate('fecha_alfa', '<=', $this->fecha_hasta);
            })
            ->when($this->compania_id, function ($query) {
                return $query->where('compania_id', $this->compania_id);
            })
            ->when($this->servicio_id, function ($query) {
                return $query->where('servicio_id', $this->servicio_id);
            })
            ->when($this->clasificacion_id, function ($query) {
                return $query->where('clasificacion_id', $this->clasificacion_id);
            })
            ->orderByDesc('fecha_alfa')
            ->get();
    }

    public function excel()
    {
        $datos = $this->cargarDatosExport();

        $encabezados = ['Compañia', 'Servicio', 'Clasificación', 'Móvil', 'A Cargo', 'Chofer', 'Tripulantes', 'Fecha'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'CBVP CCA HISTORICO.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "CBVP CCA HISTORICO";

        $datos = $this->cargarDatosExport();

        $encabezados = ['Compañia', 'Servicio', 'Clasificación', 'Móvil', 'A Cargo', 'Chofer', 'Tripulantes', 'Fecha'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
