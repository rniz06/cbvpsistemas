<?php

namespace App\Livewire\Cca\Reportes;

use App\Models\Admin\CiudadGral;
use App\Models\Admin\CompaniaGral;
use App\Models\Admin\DepartamentoGral;
use App\Models\Cca\Servicios\Clasificacion;
use App\Models\Cca\Servicios\Servicio;
use App\Exports\ExcelGenericoExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Misionales extends Component
{

    public $fecha_desde;
    public $fecha_hasta;
    public $compania_id;
    public $departamento_id;
    public $ciudad_id;
    public $servicio_id;
    public $clasificacion_id;
    public $movil_id;
    public $tipo_despacho = 'todos';
    public $falsa_alarma = 'todos';
    public $con_clasificacion = 'todos';
    public $tripulantes_desde;
    public $tripulantes_hasta;
    public $buscar;

    public $companias;
    public $departamentos;
    public $ciudades;
    public $servicios;
    public $clasificaciones;
    public $moviles;

    public function mount()
    {
        $this->fecha_desde = Carbon::now()->startOfYear()->toDateString();
        $this->fecha_hasta = Carbon::now()->toDateString();

        $this->companias = CompaniaGral::select(
            'id_compania',
            'compania'
        )->orderBy('orden')->get();

        $this->departamentos = DepartamentoGral::select(
            'id_departamento',
            'departamento'
        )->orderBy('departamento')->get();

        $this->ciudades = CiudadGral::select(
            'id_ciudad',
            'ciudad',
            'departamento_id'
        )->orderBy('ciudad')->get();

        $this->servicios = Servicio::select(
            'id_servicio',
            'servicio',
            'nombre',
            'clasificacion_boolean',
            'misional'
        )
            ->where('misional', true)
            ->orderBy('servicio')
            ->get();

        $this->clasificaciones = collect();

        $this->cargarClasificaciones();

        $this->moviles = DB::table('MAT_moviles')
            ->select(
                'id_movil',
                'movil',
                'movil_tipo_id'
            )
            ->orderBy('movil')
            ->get();
    }


    public function updated($property)
    {
        $filtros = [
            'fecha_desde',
            'fecha_hasta',
            'compania_id',
            'departamento_id',
            'ciudad_id',
            'servicio_id',
            'clasificacion_id',
            'movil_id',
            'tipo_despacho',
            'falsa_alarma',
            'con_clasificacion',
            'tripulantes_desde',
            'tripulantes_hasta',
            'buscar',
        ];

        if (!in_array($property, $filtros, true)) {
            return;
        }

        if ($property === 'servicio_id') {
            $this->clasificacion_id = null;
            $this->cargarClasificaciones();
        }

        if ($property === 'departamento_id') {
            $this->ciudad_id = null;
        }

        $this->actualizarGraficos();
    }

    public function cargarClasificaciones()
    {
        if (!$this->servicio_id) {
            $this->clasificaciones = collect();
            return;
        }

        $servicio = Servicio::find($this->servicio_id);

        if (!$servicio || !$servicio->clasificacion_boolean) {
            $this->clasificaciones = collect();
            return;
        }

        $this->clasificaciones = Clasificacion::select(
            'id_servicio_clasificacion',
            'clasificacion',
            'servicio_id',
            'misional'
        )
            ->where('servicio_id', $this->servicio_id)
            ->where('misional', true)
            ->orderBy('clasificacion')
            ->get();
    }

    private function queryServiciosPrincipales()
    {
        return DB::table('CCA_servicios_existentes as se')
            ->join(
                'CCA_servicios as s',
                's.id_servicio',
                '=',
                'se.servicio_id'
            )
            ->leftJoin(
                'CCA_servicios_clasificaciones as cl',
                'cl.id_servicio_clasificacion',
                '=',
                'se.clasificacion_id'
            )
            ->leftJoin(
                'GRAL_companias as c',
                'c.id_compania',
                '=',
                'se.compania_id'
            )
            ->leftJoin(
                'GRAL_ciudades as ci',
                'ci.id_ciudad',
                '=',
                'se.ciudad_id'
            )
            ->leftJoin(
                'GRAL_departamentos as d',
                'd.id_departamento',
                '=',
                'ci.departamento_id'
            )
            ->leftJoin(
                'MAT_moviles as m',
                'm.id_movil',
                '=',
                'se.movil_id'
            )
            ->where('s.misional', true)
            ->where(function ($query) {
                $query
                    ->where('s.clasificacion_boolean', false)
                    ->orWhere(function ($q) {
                        $q->where('s.clasificacion_boolean', true)
                            ->where('cl.misional', true);
                    });
            })
            ->where('se.estado_id', 4)
            ->select([
                'se.id_servicio_existente',
                'se.informacion_servicio',
                'se.calle_referencia',
                'se.cantidad_tripulantes',
                'se.compania_id',
                'c.compania',
                'se.servicio_id',
                's.servicio',
                's.nombre as servicio_nombre',
                's.clasificacion_boolean',
                's.misional as servicio_misional',
                'se.clasificacion_id',
                'cl.clasificacion',
                'cl.misional as clasificacion_misional',
                'se.ciudad_id',
                'ci.ciudad',
                'ci.departamento_id',
                'd.departamento',
                'se.movil_id',
                'm.movil',
                'se.acargo',
                'se.acargo_aux',
                'se.chofer',
                'se.chofer_aux',
                'se.estado_id',
                'se.falsa_alarma',
                'se.fecha_alfa',
                'se.fecha_cia',
                'se.fecha_movil',
                'se.fecha_servicio',
                'se.fecha_base',
            ]);
    }

    private function queryApoyos()
    {
        return DB::table('CCA_servicios_existentes_apoyos as a')
            ->join(
                'CCA_servicios_existentes as se',
                'se.id_servicio_existente',
                '=',
                'a.servicio_id'
            )
            ->join(
                'CCA_servicios as s',
                's.id_servicio',
                '=',
                'se.servicio_id'
            )
            ->leftJoin(
                'CCA_servicios_clasificaciones as cl',
                'cl.id_servicio_clasificacion',
                '=',
                'se.clasificacion_id'
            )
            ->leftJoin(
                'GRAL_companias as c',
                'c.id_compania',
                '=',
                'a.compania_id'
            )
            ->leftJoin(
                'GRAL_ciudades as ci',
                'ci.id_ciudad',
                '=',
                'se.ciudad_id'
            )
            ->leftJoin(
                'GRAL_departamentos as d',
                'd.id_departamento',
                '=',
                'ci.departamento_id'
            )
            ->leftJoin(
                'MAT_moviles as m',
                'm.id_movil',
                '=',
                'a.movil_id'
            )
            ->where('s.misional', true)
            ->where(function ($query) {
                $query
                    ->where('s.clasificacion_boolean', false)
                    ->orWhere(function ($q) {
                        $q->where('s.clasificacion_boolean', true)
                            ->where('cl.misional', true);
                    });
            })
            ->whereNotNull('a.fecha_base')
            ->select([
                'a.idservicio_existente_apoyo',
                'se.id_servicio_existente',
                'a.cantidad_tripulantes',
                'a.compania_id',
                'c.compania',
                'se.servicio_id',
                's.servicio',
                's.nombre as servicio_nombre',
                's.clasificacion_boolean',
                's.misional as servicio_misional',
                'se.clasificacion_id',
                'cl.clasificacion',
                'cl.misional as clasificacion_misional',
                'se.ciudad_id',
                'ci.ciudad',
                'ci.departamento_id',
                'd.departamento',
                'a.movil_id',
                'm.movil',
                'a.acargo',
                'a.acargo_aux',
                'a.fecha_cia',
                'a.fecha_movil',
                'a.fecha_servicio',
                'a.fecha_base',
            ]);
    }

    private function aplicarFiltrosPrincipales($query)
    {
        return $query
            ->when($this->fecha_desde, function ($query) {
                $query->whereDate(
                    'se.fecha_alfa',
                    '>=',
                    $this->fecha_desde
                );
            })
            ->when($this->fecha_hasta, function ($query) {
                $query->whereDate(
                    'se.fecha_alfa',
                    '<=',
                    $this->fecha_hasta
                );
            })
            ->when($this->compania_id, function ($query) {
                $query->where(
                    'se.compania_id',
                    $this->compania_id
                );
            })
            ->when($this->departamento_id, function ($query) {
                $query->where(
                    'ci.departamento_id',
                    $this->departamento_id
                );
            })
            ->when($this->ciudad_id, function ($query) {
                $query->where(
                    'se.ciudad_id',
                    $this->ciudad_id
                );
            })
            ->when($this->servicio_id, function ($query) {
                $query->where(
                    'se.servicio_id',
                    $this->servicio_id
                );
            })
            ->when($this->clasificacion_id, function ($query) {
                $query->where(
                    'se.clasificacion_id',
                    $this->clasificacion_id
                );
            })
            ->when($this->movil_id, function ($query) {
                $query->where(
                    'se.movil_id',
                    $this->movil_id
                );
            })
            ->when(
                $this->falsa_alarma !== 'todos',
                function ($query) {
                    $query->where(
                        'se.falsa_alarma',
                        $this->falsa_alarma === 'si'
                    );
                }
            )
            ->when(
                $this->con_clasificacion !== 'todos',
                function ($query) {
                    if ($this->con_clasificacion === 'si') {
                        $query->whereNotNull(
                            'se.clasificacion_id'
                        );
                    }

                    if ($this->con_clasificacion === 'no') {
                        $query->whereNull(
                            'se.clasificacion_id'
                        );
                    }
                }
            )
            ->when(
                $this->tripulantes_desde !== null &&
                $this->tripulantes_desde !== '',
                function ($query) {
                    $query->where(
                        'se.cantidad_tripulantes',
                        '>=',
                        $this->tripulantes_desde
                    );
                }
            )
            ->when(
                $this->tripulantes_hasta !== null &&
                $this->tripulantes_hasta !== '',
                function ($query) {
                    $query->where(
                        'se.cantidad_tripulantes',
                        '<=',
                        $this->tripulantes_hasta
                    );
                }
            )
            ->when($this->buscar, function ($query) {
                $buscar = '%' . trim($this->buscar) . '%';

                $query->where(function ($q) use ($buscar) {
                    $q->where('c.compania', 'LIKE', $buscar)
                        ->orWhere('s.servicio', 'LIKE', $buscar)
                        ->orWhere('s.nombre', 'LIKE', $buscar)
                        ->orWhere('cl.clasificacion', 'LIKE', $buscar)
                        ->orWhere('ci.ciudad', 'LIKE', $buscar)
                        ->orWhere('d.departamento', 'LIKE', $buscar)
                        ->orWhere('m.movil', 'LIKE', $buscar)
                        ->orWhere(
                            'se.informacion_servicio',
                            'LIKE',
                            $buscar
                        );
                });
            });
    }

    private function aplicarFiltrosApoyos($query)
    {
        return $query
            ->when($this->fecha_desde, function ($query) {
                $query->whereDate(
                    'a.fecha_cia',
                    '>=',
                    $this->fecha_desde
                );
            })
            ->when($this->fecha_hasta, function ($query) {
                $query->whereDate(
                    'a.fecha_cia',
                    '<=',
                    $this->fecha_hasta
                );
            })
            ->when($this->compania_id, function ($query) {
                $query->where(
                    'a.compania_id',
                    $this->compania_id
                );
            })
            ->when($this->departamento_id, function ($query) {
                $query->where(
                    'ci.departamento_id',
                    $this->departamento_id
                );
            })
            ->when($this->ciudad_id, function ($query) {
                $query->where(
                    'se.ciudad_id',
                    $this->ciudad_id
                );
            })
            ->when($this->servicio_id, function ($query) {
                $query->where(
                    'se.servicio_id',
                    $this->servicio_id
                );
            })
            ->when($this->clasificacion_id, function ($query) {
                $query->where(
                    'se.clasificacion_id',
                    $this->clasificacion_id
                );
            })
            ->when($this->movil_id, function ($query) {
                $query->where(
                    'a.movil_id',
                    $this->movil_id
                );
            })
            ->when(
                $this->con_clasificacion !== 'todos',
                function ($query) {
                    if ($this->con_clasificacion === 'si') {
                        $query->whereNotNull(
                            'se.clasificacion_id'
                        );
                    }

                    if ($this->con_clasificacion === 'no') {
                        $query->whereNull(
                            'se.clasificacion_id'
                        );
                    }
                }
            )
            ->when(
                $this->tripulantes_desde !== null &&
                $this->tripulantes_desde !== '',
                function ($query) {
                    $query->where(
                        'a.cantidad_tripulantes',
                        '>=',
                        $this->tripulantes_desde
                    );
                }
            )
            ->when(
                $this->tripulantes_hasta !== null &&
                $this->tripulantes_hasta !== '',
                function ($query) {
                    $query->where(
                        'a.cantidad_tripulantes',
                        '<=',
                        $this->tripulantes_hasta
                    );
                }
            )
            ->when($this->buscar, function ($query) {
                $buscar = '%' . trim($this->buscar) . '%';

                $query->where(function ($q) use ($buscar) {
                    $q->where('c.compania', 'LIKE', $buscar)
                        ->orWhere('s.servicio', 'LIKE', $buscar)
                        ->orWhere('s.nombre', 'LIKE', $buscar)
                        ->orWhere('cl.clasificacion', 'LIKE', $buscar)
                        ->orWhere('ci.ciudad', 'LIKE', $buscar)
                        ->orWhere('d.departamento', 'LIKE', $buscar)
                        ->orWhere('m.movil', 'LIKE', $buscar);
                });
            });
    }

    private function datosPrincipales()
    {
        return $this->aplicarFiltrosPrincipales(
            $this->queryServiciosPrincipales()
        );
    }

    private function datosApoyos()
    {
        return $this->aplicarFiltrosApoyos(
            $this->queryApoyos()
        );
    }

    public function kpis()
    {
        $principales = $this->datosPrincipales();
        $apoyos = $this->datosApoyos();

        $cantidadPrincipales = (clone $principales)->count();
        $cantidadApoyos = (clone $apoyos)->count();

        // Un servicio/despacho del dashboard está conformado
        // por la primera respuesta + sus despachos de apoyo.
        $servicios = $cantidadPrincipales + $cantidadApoyos;
        $totalDespachos = $servicios;

        $bomberosPrincipales = (clone $principales)->sum(
            DB::raw('COALESCE(se.cantidad_tripulantes, 0)')
        );

        $bomberosApoyos = (clone $apoyos)->sum(
            DB::raw('COALESCE(a.cantidad_tripulantes, 0)')
        );

        $bomberos = $bomberosPrincipales + $bomberosApoyos;

        $companiasPrincipales = (clone $principales)
            ->distinct('se.compania_id')
            ->count('se.compania_id');

        $companiasApoyo = (clone $apoyos)
            ->distinct('a.compania_id')
            ->count('a.compania_id');

        $ciudadesPrincipales = (clone $principales)
            ->distinct('se.ciudad_id')
            ->count('se.ciudad_id');

        $ciudadesApoyo = (clone $apoyos)
            ->distinct('se.ciudad_id')
            ->count('se.ciudad_id');

        $departamentosPrincipales = (clone $principales)
            ->distinct('ci.departamento_id')
            ->count('ci.departamento_id');

        $departamentosApoyo = (clone $apoyos)
            ->distinct('ci.departamento_id')
            ->count('ci.departamento_id');

        return [
            'servicios' => $servicios,
            'apoyos' => $cantidadApoyos,
            'total_despachos' => $totalDespachos,
            'bomberos' => $bomberos,
            'promedio_bomberos' => $totalDespachos > 0
                ? round($bomberos / $totalDespachos, 2)
                : 0,
            'companias' =>
                $companiasPrincipales + $companiasApoyo,
            'ciudades' =>
                $ciudadesPrincipales + $ciudadesApoyo,
            'departamentos' =>
                $departamentosPrincipales + $departamentosApoyo,
        ];
    }

    public function graficoMensual()
    {
        $principales = collect();
        $apoyos = collect();

        if ($this->tipo_despacho !== 'apoyo') {
            $principales = $this->aplicarFiltrosPrincipales(
                $this->queryServiciosPrincipales()
            )
                ->select(
                    DB::raw(
                        "DATE_FORMAT(se.fecha_alfa, '%Y-%m') as periodo"
                    ),
                    DB::raw('COUNT(*) as cantidad'),
                    DB::raw(
                        'SUM(COALESCE(se.cantidad_tripulantes, 0)) as bomberos'
                    )
                )
                ->groupBy('periodo')
                ->get();
        }

        if ($this->tipo_despacho !== 'principal') {
            $apoyos = $this->aplicarFiltrosApoyos(
                $this->queryApoyos()
            )
                ->select(
                    DB::raw(
                        "DATE_FORMAT(a.fecha_cia, '%Y-%m') as periodo"
                    ),
                    DB::raw('COUNT(*) as cantidad'),
                    DB::raw(
                        'SUM(COALESCE(a.cantidad_tripulantes, 0)) as bomberos'
                    )
                )
                ->groupBy('periodo')
                ->get();
        }

        return $principales
            ->merge($apoyos)
            ->groupBy('periodo')
            ->map(function ($items, $periodo) {
                return (object) [
                    'periodo' => $periodo,
                    'cantidad' => $items->sum('cantidad'),
                    'bomberos' => $items->sum('bomberos'),
                ];
            })
            ->sortBy('periodo')
            ->values();
    }

    public function graficoCompanias()
    {
        $principales = collect();
        $apoyos = collect();

        /*
        | Primera respuesta
        */
        if ($this->tipo_despacho !== 'apoyo') {
            $principales = $this->aplicarFiltrosPrincipales(
                $this->queryServiciosPrincipales()
            )
                ->select(
                    'se.compania_id as compania_id',
                    'c.compania as compania',
                    DB::raw('COUNT(*) as cantidad')
                )
                ->groupBy('se.compania_id', 'c.compania')
                ->get();
        }

        /*
        | Apoyos
        */
        if ($this->tipo_despacho !== 'principal') {
            $apoyos = $this->aplicarFiltrosApoyos(
                $this->queryApoyos()
            )
                ->select(
                    'a.compania_id as compania_id',
                    'c.compania as compania',
                    DB::raw('COUNT(*) as cantidad')
                )
                ->groupBy('a.compania_id', 'c.compania')
                ->get();
        }

        /*
        | Un servicio = primera respuesta + apoyos.
        | Por eso agrupamos ambas fuentes por compañía.
        */
        return $principales
            ->merge($apoyos)
            ->filter(function ($item) {
                return !empty($item->compania_id);
            })
            ->groupBy('compania_id')
            ->map(function ($items) {
                $primero = $items->first();

                return (object) [
                    'compania_id' => $primero->compania_id,
                    'compania' => $primero->compania ?: 'Sin compañía',
                    'cantidad' => $items->sum(function ($item) {
                        return (int) ($item->cantidad ?? 0);
                    }),
                ];
            })
            ->sortByDesc('cantidad')
            ->values();
    }

    public function graficoDepartamentos()
    {
        $principales = collect();
        $apoyos = collect();

        if ($this->tipo_despacho !== 'apoyo') {
            $principales = $this->aplicarFiltrosPrincipales(
                $this->queryServiciosPrincipales()
            )
                ->select(
                    'ci.departamento_id as departamento_id',
                    'd.departamento as departamento',
                    DB::raw('COUNT(*) as cantidad')
                )
                ->groupBy('ci.departamento_id', 'd.departamento')
                ->get();
        }

        if ($this->tipo_despacho !== 'principal') {
            $apoyos = $this->aplicarFiltrosApoyos(
                $this->queryApoyos()
            )
                ->select(
                    'ci.departamento_id as departamento_id',
                    'd.departamento as departamento',
                    DB::raw('COUNT(*) as cantidad')
                )
                ->groupBy('ci.departamento_id', 'd.departamento')
                ->get();
        }

        return $principales
            ->merge($apoyos)
            ->filter(function ($item) {
                return !empty($item->departamento_id);
            })
            ->groupBy('departamento_id')
            ->map(function ($items) {
                $primero = $items->first();

                return (object) [
                    'departamento_id' => $primero->departamento_id,
                    'departamento' => $primero->departamento ?: 'Sin departamento',
                    'cantidad' => $items->sum(function ($item) {
                        return (int) ($item->cantidad ?? 0);
                    }),
                ];
            })
            ->sortByDesc('cantidad')
            ->values();
    }

    public function graficoCiudades()
    {
        $principales = collect();
        $apoyos = collect();

        if ($this->tipo_despacho !== 'apoyo') {
            $principales = $this->aplicarFiltrosPrincipales(
                $this->queryServiciosPrincipales()
            )
                ->select(
                    'ci.id_ciudad as ciudad_id',
                    'ci.ciudad as ciudad',
                    'd.departamento as departamento',
                    DB::raw('COUNT(*) as cantidad')
                )
                ->groupBy(
                    'ci.id_ciudad',
                    'ci.ciudad',
                    'd.departamento'
                )
                ->get();
        }

        if ($this->tipo_despacho !== 'principal') {
            $apoyos = $this->aplicarFiltrosApoyos(
                $this->queryApoyos()
            )
                ->select(
                    'ci.id_ciudad as ciudad_id',
                    'ci.ciudad as ciudad',
                    'd.departamento as departamento',
                    DB::raw('COUNT(*) as cantidad')
                )
                ->groupBy(
                    'ci.id_ciudad',
                    'ci.ciudad',
                    'd.departamento'
                )
                ->get();
        }

        return $principales
            ->merge($apoyos)
            ->filter(function ($item) {
                return !empty($item->ciudad_id);
            })
            ->groupBy('ciudad_id')
            ->map(function ($items) {
                $primero = $items->first();

                return (object) [
                    'ciudad_id' => $primero->ciudad_id,
                    'ciudad' => $primero->ciudad ?: 'Sin ciudad',
                    'departamento' => $primero->departamento ?: 'Sin departamento',
                    'cantidad' => $items->sum(function ($item) {
                        return (int) ($item->cantidad ?? 0);
                    }),
                ];
            })
            ->sortByDesc('cantidad')
            ->take(20)
            ->values();
    }

    public function graficoServicios()
    {
        $principales = collect();
        $apoyos = collect();

        if ($this->tipo_despacho !== 'apoyo') {
            $principales = $this->aplicarFiltrosPrincipales(
                $this->queryServiciosPrincipales()
            )
                ->select(
                    's.id_servicio as servicio_id',
                    DB::raw(
                        "COALESCE(NULLIF(s.nombre, ''), s.servicio) as nombre"
                    ),
                    DB::raw('COUNT(*) as cantidad')
                )
                ->groupBy(
                    's.id_servicio',
                    's.nombre',
                    's.servicio'
                )
                ->get();
        }

        if ($this->tipo_despacho !== 'principal') {
            $apoyos = $this->aplicarFiltrosApoyos(
                $this->queryApoyos()
            )
                ->select(
                    's.id_servicio as servicio_id',
                    DB::raw(
                        "COALESCE(NULLIF(s.nombre, ''), s.servicio) as nombre"
                    ),
                    DB::raw('COUNT(*) as cantidad')
                )
                ->groupBy(
                    's.id_servicio',
                    's.nombre',
                    's.servicio'
                )
                ->get();
        }

        return $principales
            ->merge($apoyos)
            ->groupBy('servicio_id')
            ->map(function ($items) {
                $primero = $items->first();

                return (object) [
                    'servicio_id' => $primero->servicio_id,
                    'nombre' => $primero->nombre,
                    'cantidad' => $items->sum(function ($item) {
                        return (int) ($item->cantidad ?? 0);
                    }),
                ];
            })
            ->sortByDesc('cantidad')
            ->values();
    }

    public function graficoClasificaciones()
    {
        /*
        | Las clasificaciones pertenecen al servicio principal,
        | pero los apoyos forman parte del mismo servicio.
        | Por eso sumamos las apariciones de la clasificación
        | de primera respuesta + sus apoyos.
        */
        $principales = collect();
        $apoyos = collect();

        if ($this->tipo_despacho !== 'apoyo') {
            $principales = $this->aplicarFiltrosPrincipales(
                $this->queryServiciosPrincipales()
            )
                ->whereNotNull('se.clasificacion_id')
                ->select(
                    'cl.id_servicio_clasificacion as clasificacion_id',
                    'cl.clasificacion as clasificacion',
                    DB::raw('COUNT(*) as cantidad')
                )
                ->groupBy(
                    'cl.id_servicio_clasificacion',
                    'cl.clasificacion'
                )
                ->get();
        }

        if ($this->tipo_despacho !== 'principal') {
            $apoyos = $this->aplicarFiltrosApoyos(
                $this->queryApoyos()
            )
                ->whereNotNull('se.clasificacion_id')
                ->select(
                    'cl.id_servicio_clasificacion as clasificacion_id',
                    'cl.clasificacion as clasificacion',
                    DB::raw('COUNT(*) as cantidad')
                )
                ->groupBy(
                    'cl.id_servicio_clasificacion',
                    'cl.clasificacion'
                )
                ->get();
        }

        return $principales
            ->merge($apoyos)
            ->groupBy('clasificacion_id')
            ->map(function ($items) {
                $primero = $items->first();

                return (object) [
                    'clasificacion_id' => $primero->clasificacion_id,
                    'clasificacion' => $primero->clasificacion,
                    'cantidad' => $items->sum(function ($item) {
                        return (int) ($item->cantidad ?? 0);
                    }),
                ];
            })
            ->sortByDesc('cantidad')
            ->values();
    }

    public function graficoTipoDespacho()
    {
        if ($this->tipo_despacho === 'principal') {
            return [
                'principal' =>
                    (clone $this->datosPrincipales())->count(),
                'apoyo' => 0,
            ];
        }

        if ($this->tipo_despacho === 'apoyo') {
            return [
                'principal' => 0,
                'apoyo' =>
                    (clone $this->datosApoyos())->count(),
            ];
        }

        return [
            'principal' =>
                (clone $this->datosPrincipales())->count(),
            'apoyo' =>
                (clone $this->datosApoyos())->count(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | BOMBEROS PARTICIPANTES POR COMPAÑÍA - CORREGIDO
    |--------------------------------------------------------------------------
    */

    public function graficoBomberosCompania()
    {
        $datos = collect();

        /*
        | Primera respuesta
        */

        if ($this->tipo_despacho !== 'apoyo') {
            $principales = $this->aplicarFiltrosPrincipales(
                $this->queryServiciosPrincipales()
            )
                ->select([
                    'se.compania_id as compania_id',
                    'c.compania as compania',
                    'se.cantidad_tripulantes as tripulantes',
                ])
                ->get();

            $datos = $datos->merge($principales);
        }

        /*
        | Apoyos
        */

        if ($this->tipo_despacho !== 'principal') {
            $apoyos = $this->aplicarFiltrosApoyos(
                $this->queryApoyos()
            )
                ->select([
                    'a.compania_id as compania_id',
                    'c.compania as compania',
                    'a.cantidad_tripulantes as tripulantes',
                ])
                ->get();

            $datos = $datos->merge($apoyos);
        }

        /*
        | Agrupamos por ID REAL de compañía.
        | No agrupamos por nombre.
        */

        return $datos
            ->filter(function ($item) {
                return !empty($item->compania_id);
            })
            ->groupBy('compania_id')
            ->map(function ($items) {
                $primero = $items->first();

                return (object) [
                    'compania_id' => $primero->compania_id,
                    'compania' =>
                        $primero->compania ?: 'Sin compañía',
                    'bomberos' =>
                        $items->sum(function ($item) {
                            return (int) (
                                $item->tripulantes ?? 0
                            );
                        }),
                ];
            })
            ->sortByDesc('bomberos')
            ->values();
    }

    public function graficoBomberosServicio()
    {
        if ($this->tipo_despacho === 'apoyo') {
            return $this->aplicarFiltrosApoyos(
                $this->queryApoyos()
            )
                ->select(
                    DB::raw(
                        "COALESCE(NULLIF(s.nombre, ''), s.servicio) as nombre"
                    ),
                    DB::raw(
                        'SUM(COALESCE(a.cantidad_tripulantes, 0)) as bomberos'
                    )
                )
                ->groupBy(
                    's.id_servicio',
                    's.nombre',
                    's.servicio'
                )
                ->orderByDesc('bomberos')
                ->get();
        }

        if ($this->tipo_despacho === 'principal') {
            return $this->aplicarFiltrosPrincipales(
                $this->queryServiciosPrincipales()
            )
                ->select(
                    DB::raw(
                        "COALESCE(NULLIF(s.nombre, ''), s.servicio) as nombre"
                    ),
                    DB::raw(
                        'SUM(COALESCE(se.cantidad_tripulantes, 0)) as bomberos'
                    )
                )
                ->groupBy(
                    's.id_servicio',
                    's.nombre',
                    's.servicio'
                )
                ->orderByDesc('bomberos')
                ->get();
        }

        $principales = $this->aplicarFiltrosPrincipales(
            $this->queryServiciosPrincipales()
        )
            ->select(
                DB::raw(
                    "COALESCE(NULLIF(s.nombre, ''), s.servicio) as nombre"
                ),
                DB::raw(
                    'SUM(COALESCE(se.cantidad_tripulantes, 0)) as bomberos'
                )
            )
            ->groupBy(
                's.id_servicio',
                's.nombre',
                's.servicio'
            )
            ->get();

        $apoyos = $this->aplicarFiltrosApoyos(
            $this->queryApoyos()
        )
            ->select(
                DB::raw(
                    "COALESCE(NULLIF(s.nombre, ''), s.servicio) as nombre"
                ),
                DB::raw(
                    'SUM(COALESCE(a.cantidad_tripulantes, 0)) as bomberos'
                )
            )
            ->groupBy(
                's.id_servicio',
                's.nombre',
                's.servicio'
            )
            ->get();

        return $principales
            ->merge($apoyos)
            ->groupBy('nombre')
            ->map(function ($items, $nombre) {
                return (object) [
                    'nombre' => $nombre,
                    'bomberos' => $items->sum('bomberos'),
                ];
            })
            ->sortByDesc('bomberos')
            ->values();
    }

    private function actualizarGraficos()
    {
        $this->dispatch(
            'misionales-charts-updated',
            mensual: $this->graficoMensual(),
            companias: $this->graficoCompanias(),
            departamentos: $this->graficoDepartamentos(),
            ciudades: $this->graficoCiudades(),
            servicios: $this->graficoServicios(),
            clasificaciones: $this->graficoClasificaciones(),
            tipo: $this->graficoTipoDespacho(),
            bomberosCompania: $this->graficoBomberosCompania(),
            bomberosServicio: $this->graficoBomberosServicio()
        );
    }


    public function excel()
    {
        $principales = $this->datosPrincipales()->get();
        $apoyos = $this->datosApoyos()->get();

        $datos = collect();

        foreach ($principales as $item) {
            $datos->push([
                'Tipo' => 'PRIMERA RESPUESTA',
                'Fecha' => $item->fecha_alfa
                    ? Carbon::parse(
                        $item->fecha_alfa
                    )->format('d/m/Y H:i:s')
                    : null,
                'Compañía' => $item->compania,
                'Departamento' => $item->departamento,
                'Ciudad' => $item->ciudad,
                'Servicio' => $item->servicio,
                'Nombre' => $item->servicio_nombre,
                'Clasificación' => $item->clasificacion,
                'Móvil' => $item->movil,
                'Tripulantes' => $item->cantidad_tripulantes,
            ]);
        }

        foreach ($apoyos as $item) {
            $datos->push([
                'Tipo' => 'APOYO',
                'Fecha' => $item->fecha_cia
                    ? Carbon::parse(
                        $item->fecha_cia
                    )->format('d/m/Y H:i:s')
                    : null,
                'Compañía' => $item->compania,
                'Departamento' => $item->departamento,
                'Ciudad' => $item->ciudad,
                'Servicio' => $item->servicio,
                'Nombre' => $item->servicio_nombre,
                'Clasificación' => $item->clasificacion,
                'Móvil' => $item->movil,
                'Tripulantes' => $item->cantidad_tripulantes,
            ]);
        }

        return Excel::download(
            new ExcelGenericoExport($datos),
            'reporte-servicios-misionales.xlsx'
        );
    }

    public function limpiarFiltros()
    {
        $this->fecha_desde = Carbon::now()
            ->startOfYear()
            ->toDateString();

        $this->fecha_hasta = Carbon::now()
            ->toDateString();

        $this->compania_id = null;
        $this->departamento_id = null;
        $this->ciudad_id = null;
        $this->servicio_id = null;
        $this->clasificacion_id = null;
        $this->movil_id = null;
        $this->tipo_despacho = 'todos';
        $this->falsa_alarma = 'todos';
        $this->con_clasificacion = 'todos';
        $this->tripulantes_desde = null;
        $this->tripulantes_hasta = null;
        $this->buscar = null;

        $this->clasificaciones = collect();


        $this->actualizarGraficos();
    }

    public function render()
    {
        return view(
            'livewire.cca.reportes.misionales',
            [
                'kpis' =>
                    $this->kpis(),

                'mensual' =>
                    $this->graficoMensual(),

                'companiasGrafico' =>
                    $this->graficoCompanias(),

                'departamentosGrafico' =>
                    $this->graficoDepartamentos(),

                'ciudadesGrafico' =>
                    $this->graficoCiudades(),

                'serviciosGrafico' =>
                    $this->graficoServicios(),

                'clasificacionesGrafico' =>
                    $this->graficoClasificaciones(),

                'tipoDespachoGrafico' =>
                    $this->graficoTipoDespacho(),

                'bomberosCompaniaGrafico' =>
                    $this->graficoBomberosCompania(),

                'bomberosServicioGrafico' =>
                    $this->graficoBomberosServicio(),

           
            ]
        );
    }
}