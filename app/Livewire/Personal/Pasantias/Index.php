<?php

namespace App\Livewire\Personal\Pasantias;

use App\Models\Personal;
use App\Models\Personal\Pasantia;
use App\Models\Vistas\GralVtCompania;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public string $buscar = '';
    public string $filtroCompania = '';
    public string $filtroEstado = '';
    public string $filtroFechaInicio = '';
    public string $filtroFechaFin = '';
    public int $paginado = 10;

    public bool $mostrarFormulario = false;

    public string $buscarPersonal = '';
    public ?int $personalSeleccionadoId = null;
    public ?int $companiaOrigenId = null;
    public string $companiaDestinoId = '';
    public string $fechaInicio = '';
    public string $fechaFin = '';
    public string $observaciones = '';

    public function mount(): void
    {
        $this->autorizarListado();
    }

    private function autorizarListado(): void
    {
        abort_unless(
            Auth::check()
                && Auth::user()->can('Personal Pasantias Listar'),
            403,
            'No tenés permiso para consultar las pasantías.'
        );
    }

    private function autorizarCreacion(): void
    {
        abort_unless(
            Auth::check()
                && Auth::user()->can('Personal Pasantias Crear'),
            403,
            'No tenés permiso para registrar pasantías.'
        );
    }

    public function updating($property): void
    {
        if (in_array($property, [
            'buscar',
            'filtroCompania',
            'filtroEstado',
            'filtroFechaInicio',
            'filtroFechaFin',
            'paginado',
        ], true)) {
            $this->resetPage();
        }
    }

    /**
     * Permite filtrar el listado desde las tarjetas de alertas.
     */
    public function filtrarPorEstado(string $estado): void
    {
        $this->autorizarListado();

        $estadosPermitidos = [
            '',
            'PENDIENTE',
            'VIGENTE',
            'VENCIDA',
            'VENCIDA_7_DIAS',
            'POR_VENCER_7_DIAS',
        ];

        if (!in_array($estado, $estadosPermitidos, true)) {
            return;
        }

        $this->filtroEstado = $estado;
        $this->resetPage();
    }

    public function abrirFormulario(): void
    {
        $this->autorizarCreacion();

        $this->reset([
            'buscarPersonal',
            'personalSeleccionadoId',
            'companiaOrigenId',
            'companiaDestinoId',
            'fechaInicio',
            'fechaFin',
            'observaciones',
        ]);

        $this->mostrarFormulario = true;
    }

    public function cerrarFormulario(): void
    {
        $this->mostrarFormulario = false;
    }

    public function seleccionarPersonal(int $id): void
    {
        $this->autorizarCreacion();

        $personal = Personal::query()
            ->where('estado_id', 1)
            ->findOrFail($id);

        if (!$personal->compania_id) {
            throw ValidationException::withMessages([
                'personalSeleccionadoId' =>
                    'El bombero no tiene una compañía de origen registrada.',
            ]);
        }

        $this->personalSeleccionadoId = (int) $personal->idpersonal;
        $this->companiaOrigenId = (int) $personal->compania_id;

        $this->buscarPersonal = sprintf(
            '%s - Código %s',
            $personal->nombrecompleto,
            $personal->codigo
        );
    }

    public function quitarPersonal(): void
    {
        $this->personalSeleccionadoId = null;
        $this->companiaOrigenId = null;
        $this->buscarPersonal = '';
    }

    public function guardar(): void
    {
        $this->autorizarCreacion();

        $datos = $this->validate([
            'personalSeleccionadoId' => ['required', 'integer'],
            'companiaOrigenId' => ['required', 'integer'],
            'companiaDestinoId' => ['required', 'integer'],
            'fechaInicio' => ['required', 'date'],
            'fechaFin' => [
                'required',
                'date',
                'after_or_equal:fechaInicio',
            ],
            'observaciones' => ['nullable', 'string', 'max:5000'],
        ], [
            'personalSeleccionadoId.required' => 'Seleccioná un bombero.',
            'companiaDestinoId.required' => 'Seleccioná una compañía de destino.',
            'fechaInicio.required' => 'La fecha de inicio es obligatoria.',
            'fechaFin.required' => 'La fecha de fin es obligatoria.',
            'fechaFin.after_or_equal' =>
                'La fecha de fin no puede ser anterior a la fecha de inicio.',
        ]);

        $destinoId = (int) $datos['companiaDestinoId'];

        $destinoExiste = GralVtCompania::query()
            ->whereKey($destinoId)
            ->exists();

        if (!$destinoExiste) {
            throw ValidationException::withMessages([
                'companiaDestinoId' =>
                    'La compañía de destino seleccionada no existe.',
            ]);
        }

        DB::transaction(function () use ($datos, $destinoId) {
            $personal = Personal::query()
                ->where('estado_id', 1)
                ->whereKey($datos['personalSeleccionadoId'])
                ->lockForUpdate()
                ->firstOrFail();

            // La compañía de origen se obtiene de la ficha del bombero.
            // No se modifica la compañía de origen del registro de personal.
            $origenId = (int) $personal->compania_id;

            if (!$origenId) {
                throw ValidationException::withMessages([
                    'personalSeleccionadoId' =>
                        'El bombero no tiene una compañía de origen registrada.',
                ]);
            }

            if ($origenId === $destinoId) {
                throw ValidationException::withMessages([
                    'companiaDestinoId' =>
                        'La compañía de destino debe ser distinta de la compañía de origen.',
                ]);
            }

            // Impide registrar períodos que se superpongan para el mismo bombero.
            $superpuesta = Pasantia::query()
                ->where('personal_id', $personal->idpersonal)
                ->whereDate('fecha_inicio', '<=', $datos['fechaFin'])
                ->whereDate('fecha_fin', '>=', $datos['fechaInicio'])
                ->exists();

            if ($superpuesta) {
                throw ValidationException::withMessages([
                    'fechaInicio' =>
                        'El bombero ya tiene una pasantía registrada que se superpone con este período.',
                ]);
            }

            Pasantia::create([
                'personal_id' => $personal->idpersonal,
                'compania_origen_id' => $origenId,
                'compania_destino_id' => $destinoId,
                'fecha_inicio' => $datos['fechaInicio'],
                'fecha_fin' => $datos['fechaFin'],
                'observaciones' => $datos['observaciones'] ?? null,
                'registrado_por' => Auth::id(),
            ]);
        });

        $this->mostrarFormulario = false;

        $this->reset([
            'buscarPersonal',
            'personalSeleccionadoId',
            'companiaOrigenId',
            'companiaDestinoId',
            'fechaInicio',
            'fechaFin',
            'observaciones',
        ]);

        session()->flash(
            'success',
            'La pasantía fue registrada correctamente.'
        );

        $this->resetPage();
    }

    public function limpiarFiltros(): void
    {
        $this->reset([
            'buscar',
            'filtroCompania',
            'filtroEstado',
            'filtroFechaInicio',
            'filtroFechaFin',
        ]);

        $this->resetPage();
    }

    public function render()
    {
        $this->autorizarListado();

        $hoy = Carbon::today()->toDateString();
        $haceSieteDias = Carbon::today()->subDays(7)->toDateString();
        $dentroDeSieteDias = Carbon::today()->addDays(7)->toDateString();

        /*
        |--------------------------------------------------------------------------
        | Contadores generales de pasantías
        |--------------------------------------------------------------------------
        | Los contadores no dependen de los filtros del listado.
        */

        $totalPasantias = Pasantia::query()->count();

        $totalVigentes = Pasantia::query()
            ->whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy)
            ->count();

        // Pasantías cuya fecha de finalización ocurrió entre hace 7 días y ayer.
        $totalVencidas = Pasantia::query()
            ->whereDate('fecha_fin', '>=', $haceSieteDias)
            ->whereDate('fecha_fin', '<', $hoy)
            ->count();

        // Pasantías actualmente vigentes que terminan entre hoy y los próximos 7 días.
        $totalPorVencer = Pasantia::query()
            ->whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy)
            ->whereDate('fecha_fin', '<=', $dentroDeSieteDias)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Catálogo de compañías
        |--------------------------------------------------------------------------
        */

        $companias = GralVtCompania::query()
            ->orderBy('compania')
            ->get(['id_compania', 'compania']);

        /*
        |--------------------------------------------------------------------------
        | Listado de pasantías
        |--------------------------------------------------------------------------
        */

        $query = Pasantia::query()->with([
            'personal',
            'companiaOrigen',
            'companiaDestino',
            'registradoPor',
        ]);

        if ($this->filtroCompania !== '') {
            $companiaId = (int) $this->filtroCompania;

            $query->where(function ($q) use ($companiaId) {
                $q->where('compania_origen_id', $companiaId)
                    ->orWhere('compania_destino_id', $companiaId);
            });
        }

        if ($this->filtroEstado === 'PENDIENTE') {
            $query->whereDate('fecha_inicio', '>', $hoy);
        } elseif ($this->filtroEstado === 'VIGENTE') {
            $query->whereDate('fecha_inicio', '<=', $hoy)
                ->whereDate('fecha_fin', '>=', $hoy);
        } elseif ($this->filtroEstado === 'VENCIDA') {
            $query->whereDate('fecha_fin', '<', $hoy);
        } elseif ($this->filtroEstado === 'VENCIDA_7_DIAS') {
            $query->whereDate('fecha_fin', '>=', $haceSieteDias)
                ->whereDate('fecha_fin', '<', $hoy);
        } elseif ($this->filtroEstado === 'POR_VENCER_7_DIAS') {
            $query->whereDate('fecha_inicio', '<=', $hoy)
                ->whereDate('fecha_fin', '>=', $hoy)
                ->whereDate('fecha_fin', '<=', $dentroDeSieteDias);
        }

        if ($this->filtroFechaInicio !== '') {
            $query->whereDate(
                'fecha_inicio',
                '>=',
                $this->filtroFechaInicio
            );
        }

        if ($this->filtroFechaFin !== '') {
            $query->whereDate(
                'fecha_fin',
                '<=',
                $this->filtroFechaFin
            );
        }

        $termino = trim($this->buscar);

        if ($termino !== '') {
            $companiasCoincidentes = GralVtCompania::query()
                ->where('compania', 'like', "%{$termino}%")
                ->pluck('id_compania')
                ->all();

            $query->where(function ($q) use (
                $termino,
                $companiasCoincidentes
            ) {
                $q->whereHas('personal', function ($personalQuery) use (
                    $termino
                ) {
                    $personalQuery->where(function ($p) use ($termino) {
                        $p->where(
                            'nombrecompleto',
                            'like',
                            "%{$termino}%"
                        )
                            ->orWhere(
                                'codigo',
                                'like',
                                "%{$termino}%"
                            )
                            ->orWhere(
                                'documento',
                                'like',
                                "%{$termino}%"
                            );
                    });
                });

                if (!empty($companiasCoincidentes)) {
                    $q->orWhereIn(
                        'compania_origen_id',
                        $companiasCoincidentes
                    )->orWhereIn(
                        'compania_destino_id',
                        $companiasCoincidentes
                    );
                }
            });
        }

        $pasantias = $query
            ->orderByDesc('fecha_inicio')
            ->orderByDesc('id_pasantia')
            ->paginate($this->paginado);

        /*
        |--------------------------------------------------------------------------
        | Búsqueda de personal para el formulario
        |--------------------------------------------------------------------------
        */

        $resultadosPersonal = collect();

        if (
            $this->mostrarFormulario
            && mb_strlen(trim($this->buscarPersonal)) >= 2
            && !$this->personalSeleccionadoId
        ) {
            $busquedaPersonal = trim($this->buscarPersonal);

            $resultadosPersonal = Personal::query()
                ->where('estado_id', 1)
                ->whereNotNull('compania_id')
                ->where(function ($q) use ($busquedaPersonal) {
                    $q->where(
                        'nombrecompleto',
                        'like',
                        "%{$busquedaPersonal}%"
                    )
                        ->orWhere(
                            'codigo',
                            'like',
                            "%{$busquedaPersonal}%"
                        )
                        ->orWhere(
                            'documento',
                            'like',
                            "%{$busquedaPersonal}%"
                        );
                })
                ->orderBy('nombrecompleto')
                ->limit(15)
                ->get([
                    'idpersonal',
                    'nombrecompleto',
                    'codigo',
                    'documento',
                    'compania_id',
                ]);
        }

        $nombreCompaniaOrigen = null;

        if ($this->companiaOrigenId) {
            $nombreCompaniaOrigen = GralVtCompania::query()
                ->whereKey($this->companiaOrigenId)
                ->value('compania');
        }

        return view('livewire.personal.pasantias.index', [
            'pasantias' => $pasantias,
            'companias' => $companias,
            'resultadosPersonal' => $resultadosPersonal,
            'nombreCompaniaOrigen' => $nombreCompaniaOrigen,

            'totalPasantias' => $totalPasantias,
            'totalVigentes' => $totalVigentes,
            'totalVencidas' => $totalVencidas,
            'totalPorVencer' => $totalPorVencer,
        ]);
    }
}
