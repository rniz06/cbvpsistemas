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

    public function excel()
    {
        $datos = VtExistente::select('compania', 'servicio', 'clasificacion', DB::raw("CONCAT(tipo, '-', movil) AS tipo_movil"), DB::raw("CONCAT(nombrecompleto, '-', codigo, '-', categoria) AS acargo"), 'chofer', 'cantidad_tripulantes', 'fecha_alfa')
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
            })->orderByDesc('fecha_alfa')->get();

        $encabezados = ['Compañia', 'Servicio', 'Clasificación', 'Móvil', 'A Cargo', 'Chofer', 'Tripulantes', 'Fecha'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'CBVP CCA HISTORICO.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "CBVP CCA HISTORICO";
        $datos = VtExistente::select('compania', 'servicio', 'clasificacion', DB::raw("CONCAT(tipo, '-', movil) AS tipo_movil"), DB::raw("CONCAT(nombrecompleto, '-', codigo, '-', categoria) AS acargo"), 'chofer', 'cantidad_tripulantes', 'fecha_alfa')
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
            })->orderByDesc('fecha_alfa')->get();

        $encabezados = ['Compañia', 'Servicio', 'Clasificación', 'Móvil', 'A Cargo', 'Chofer', 'Tripulantes', 'Fecha'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
