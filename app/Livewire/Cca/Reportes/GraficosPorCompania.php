<?php

namespace App\Livewire\Cca\Reportes;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Admin\CompaniaGral;
use App\Models\Cca\Servicios\Clasificacion;
use App\Models\Cca\Servicios\Servicio;
use App\Models\Vistas\Cca\VtExistente;
use App\Models\Vistas\Cca\VtExistenteApoyo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class GraficosPorCompania extends Component
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

    public $paginadoServicios = 10;
    public $paginadoClasificaciones = 10;
    public $paginadoServiciosApoyos = 10;
    public $paginadoClasificacionesApoyos = 10;

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'paginadoServicios',
            'paginadoClasificaciones',
            'fecha_desde',
            'fecha_hasta',
            'compania_id',
            'servicio_id',
            'clasificacion_id',
        ])) {
            $this->resetPage('servicios_page');
            $this->resetPage('clasificiones_page');
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

    public function cargarServicios()
    {
        return VtExistente::select('servicio', DB::raw("COUNT(servicio_id) AS conteo"))
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
            ->groupBy('servicio')->paginate($this->paginadoServicios, ['*'], 'servicios_page');
    }

    public function cargarClasificaciones()
    {
        return VtExistente::select('clasificacion', DB::raw("COUNT(servicio_id) AS conteo"))
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
            })->groupBy('clasificacion')->paginate($this->paginadoClasificaciones, ['*'], 'clasificiones_page');
    }

    public function cargarServiciosApoyos()
    {
        return VtExistenteApoyo::select('servicio', DB::raw("COUNT(servicio_id) AS conteo"))
            ->when($this->fecha_desde, function ($query) {
                return $query->whereDate('fecha_cia', '>=', $this->fecha_desde);
            })
            ->when($this->fecha_hasta, function ($query) {
                return $query->whereDate('fecha_cia', '<=', $this->fecha_hasta);
            })
            ->when($this->compania_id, function ($query) {
                return $query->where('compania_id', $this->compania_id);
            })
            ->when($this->servicio_id, function ($query) {
                return $query->where('servicio_id', $this->servicio_id);
            })
            ->groupBy('servicio')->paginate($this->paginadoServiciosApoyos, ['*'], 'servicios_apoyos_page');
    }

    public function cargarClasificacionesApoyos()
    {
        return VtExistenteApoyo::select('clasificacion', DB::raw("COUNT(servicio_id) AS conteo"))
            ->when($this->fecha_desde, function ($query) {
                return $query->whereDate('fecha_cia', '>=', $this->fecha_desde);
            })
            ->when($this->fecha_hasta, function ($query) {
                return $query->whereDate('fecha_cia', '<=', $this->fecha_hasta);
            })
            ->when($this->compania_id, function ($query) {
                return $query->where('compania_id', $this->compania_id);
            })
            ->when($this->servicio_id, function ($query) {
                return $query->where('servicio_id', $this->servicio_id);
            })
            ->when($this->clasificacion_id, function ($query) {
                return $query->where('clasificacion_id', $this->clasificacion_id);
            })->groupBy('clasificacion')->paginate($this->paginadoClasificacionesApoyos, ['*'], 'clasificiones_apoyos_page');
    }

    public function conteoServiciosYapoyosTotal()
    {
        $filters = [
            'fecha_desde' => $this->fecha_desde,
            'fecha_hasta' => $this->fecha_hasta,
            'compania_id' => $this->compania_id,
            'servicio_id' => $this->servicio_id,
        ];

        // Subconsulta 1 (vt_servicios_existentes)
        $whereExistentes = "estado_id = 4";
        // Subconsulta 2 (apoyos)
        $whereApoyos = "1=1";

        if ($filters['fecha_desde']) {
            $whereExistentes .= " AND DATE(fecha_alfa) >= :fecha_desde_1";
            $whereApoyos .= " AND DATE(fecha_cia) >= :fecha_desde_2";
        }

        if ($filters['fecha_hasta']) {
            $whereExistentes .= " AND DATE(fecha_alfa) <= :fecha_hasta_1";
            $whereApoyos .= " AND DATE(fecha_cia) <= :fecha_hasta_2";
        }

        if ($filters['compania_id']) {
            $whereExistentes .= " AND compania_id = :compania_id_1";
            $whereApoyos .= " AND compania_id = :compania_id_2";
        }

        if ($filters['servicio_id']) {
            $whereExistentes .= " AND servicio_id = :servicio_id_1";
            $whereApoyos .= " AND servicio_id = :servicio_id_2";
        }

        $query = "
        SELECT servicio, SUM(conteo) as conteo_total
        FROM (
            SELECT servicio, COUNT(servicio_id) as conteo
            FROM personalcbvp.CCA_vt_servicios_existentes
            WHERE $whereExistentes
            GROUP BY servicio

            UNION ALL

            SELECT servicio, COUNT(servicio_id) as conteo
            FROM personalcbvp.CCA_vt_servicios_existentes_apoyos
            WHERE $whereApoyos
            GROUP BY servicio
        ) AS union_servicios
        GROUP BY servicio
        ORDER BY conteo_total DESC
    ";

        // Asociamos los parámetros renombrados con sus valores
        $bindings = [];

        if ($filters['fecha_desde']) {
            $bindings['fecha_desde_1'] = $filters['fecha_desde'];
            $bindings['fecha_desde_2'] = $filters['fecha_desde'];
        }
        if ($filters['fecha_hasta']) {
            $bindings['fecha_hasta_1'] = $filters['fecha_hasta'];
            $bindings['fecha_hasta_2'] = $filters['fecha_hasta'];
        }
        if ($filters['compania_id']) {
            $bindings['compania_id_1'] = $filters['compania_id'];
            $bindings['compania_id_2'] = $filters['compania_id'];
        }
        if ($filters['servicio_id']) {
            $bindings['servicio_id_1'] = $filters['servicio_id'];
            $bindings['servicio_id_2'] = $filters['servicio_id'];
        }

        return DB::select($query, $bindings);
    }




    public function render()
    {
        return view('livewire.cca.reportes.graficos-por-compania', [
            'serviciosTabla' => $this->cargarServicios(),
            'clasificacionesTabla' => $this->cargarClasificaciones(),
            'serviciosApoyosTabla' => $this->cargarServiciosApoyos(),
            'clasificacionesApoyosTabla' => $this->cargarClasificacionesApoyos(),
            'conteoServiciosYApoyos' => $this->conteoServiciosYapoyosTotal()
        ]);
    }

    public function excelServicios()
    {
        $datos = VtExistente::select('servicio', DB::raw("COUNT(servicio_id) AS conteo"))
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
            ->groupBy('servicio')->get();

        $encabezados = ['Servicio', 'Conteo'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'CBVP CCA GRAFICO.xlsx');
    }

    public function pdfServicios()
    {
        $nombre_archivo = "CBVP CCA GRAFICO";
        $datos = VtExistente::select('servicio', DB::raw("COUNT(servicio_id) AS conteo"))
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
            ->groupBy('servicio')->get();

        $encabezados = ['Servicio', 'Conteo'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }

    public function excelClasificaciones()
    {
        $datos = VtExistente::select('clasificacion', DB::raw("COUNT(servicio_id) AS conteo"))
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
            })->groupBy('clasificacion')->get();

        $encabezados = ['Clasificacion', 'Conteo'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'CBVP CCA GRAFICO.xlsx');
    }

    public function pdfClasificaciones()
    {
        $nombre_archivo = "CBVP CCA GRAFICO";
        $datos = VtExistente::select('clasificacion', DB::raw("COUNT(servicio_id) AS conteo"))
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
            })->groupBy('clasificacion')->get();

        $encabezados = ['Clasificacion', 'Conteo'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }

    public function excelClasificacionesApoyos()
    {
        $datos = VtExistente::select('clasificacion', DB::raw("COUNT(servicio_id) AS conteo"))
            ->where('estado_id', 4) // Servicio Culminado
            ->when($this->fecha_desde, function ($query) {
                return $query->whereDate('fecha_cia', '>=', $this->fecha_desde);
            })
            ->when($this->fecha_hasta, function ($query) {
                return $query->whereDate('fecha_cia', '<=', $this->fecha_hasta);
            })
            ->when($this->compania_id, function ($query) {
                return $query->where('compania_id', $this->compania_id);
            })
            ->when($this->servicio_id, function ($query) {
                return $query->where('servicio_id', $this->servicio_id);
            })
            ->when($this->clasificacion_id, function ($query) {
                return $query->where('clasificacion_id', $this->clasificacion_id);
            })->groupBy('clasificacion')->get();

        $encabezados = ['Clasificacion', 'Conteo'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'CBVP CCA GRAFICO.xlsx');
    }

    public function pdfClasificacionesApoyos()
    {
        $nombre_archivo = "CBVP CCA GRAFICO";
        $datos = VtExistente::select('clasificacion', DB::raw("COUNT(servicio_id) AS conteo"))
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
            })->groupBy('clasificacion')->get();

        $encabezados = ['Clasificacion', 'Conteo'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
