<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Gral\Compania;
use App\Models\Personal;
use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Detalle;
use App\Models\Personal\Asistencia\Estado;
use App\Models\Personal\Asistencia\Periodo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class GenerarManualmente extends Component
{
    public $compania_id;
    public $periodo_id;
    public $estado_id;

    public $companias = [];
    public $periodos = [];
    public $estados = [];

    /**
     * Estados de personal que pueden integrar las planillas.
     *
     * 1  = VIGENTE
     * 5  = SUSPENDIDO
     * 8  = PERIODO DE PRUEBA
     * 9  = REINTEGRO PROVISORIO
     */
    private const ESTADOS_ELEGIBLES = [1, 5, 8, 9];

    /**
     * P4 = COMBATIENTE (categoria_id 1)
     * P5 = ACTIVO      (categoria_id 2)
     */
    private const TIPOS_ASISTENCIA = [
        'P4' => 1,
        'P5' => 2,
    ];

    public function mount(): void
    {
        $this->companias = Compania::orderBy('orden')
            ->get(['id_compania', 'compania']);

        $this->periodos = Periodo::with([
                'mes:id_mes,mes',
                'anho:id_anho,anho',
            ])
            ->orderByDesc('anho_id')
            ->orderByDesc('mes_id')
            ->get();

        $this->estados = Estado::select(
            'id_asistencia_estado',
            'estado'
        )->get();
    }

    protected function rules(): array
    {
        return [
            'compania_id' => [
                'required',
                'integer',
                Rule::exists('GRAL_companias', 'id_compania'),
            ],

            'periodo_id' => [
                'required',
                'integer',
                Rule::exists(
                    'PER_asistencias_periodos',
                    'id_asistencia_periodo'
                ),
            ],

            'estado_id' => [
                'required',
                'integer',
                Rule::exists(
                    'PER_asistencias_estados',
                    'id_asistencia_estado'
                ),
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'compania_id.required' =>
                'Seleccioná una compañía.',

            'periodo_id.required' =>
                'Seleccioná un período.',

            'estado_id.required' =>
                'Seleccioná el estado inicial de las planillas.',
        ];
    }

    public function guardar(): void
    {
        $this->validate();

        try {
            DB::transaction(function () {
                /*
                 * Comprobar si ya existe cualquiera de las dos
                 * planillas para la misma compañía y período.
                 *
                 * Si existe una, no se genera ninguna nueva.
                 */
                foreach (array_keys(self::TIPOS_ASISTENCIA) as $tipo) {
                    $existe = Asistencia::withTrashed()
                        ->where('compania_id', $this->compania_id)
                        ->where('periodo_id', $this->periodo_id)
                        ->where('tipo_asistencia', $tipo)
                        ->exists();

                    if ($existe) {
                        throw new \RuntimeException(
                            "Ya existe una planilla {$tipo} para esta compañía y período. " .
                            'No se generaron nuevas planillas.'
                        );
                    }
                }

                /*
                 * Generar P4 y P5 por separado.
                 */
                foreach (self::TIPOS_ASISTENCIA as $tipo => $categoriaId) {
                    $asistencia = Asistencia::create([
                        'compania_id' => $this->compania_id,
                        'periodo_id' => $this->periodo_id,
                        'estado_id' => $this->estado_id,
                        'tipo_asistencia' => $tipo,
                        'hubo_citacion' => false,
                    ]);

                    /*
                     * Obtener únicamente el personal de la categoría
                     * correspondiente y con estado elegible.
                     */
                    $personales = Personal::query()
                        ->where('compania_id', $this->compania_id)
                        ->where('categoria_id', $categoriaId)
                        ->whereIn(
                            'estado_id',
                            self::ESTADOS_ELEGIBLES
                        )
                        ->orderBy('codigo')
                        ->get([
                            'idpersonal',
                            'estado_id',
                        ]);

                    foreach ($personales as $personal) {
                        Detalle::create([
                            'asistencia_id' =>
                                $asistencia->id_asistencia,

                            'personal_id' =>
                                $personal->idpersonal,

                            // P4 utiliza práctica; P5 no.
                            'practica' => $tipo === 'P4'
                                ? 0
                                : null,

                            'guardia' => 0,

                            // La citación comienza deshabilitada.
                            'citacion' => null,

                            'total' => 0,
                        ]);
                    }
                }
            });

            session()->flash(
                'success',
                'SE GENERARON CORRECTAMENTE LAS PLANILLAS P4 Y P5.'
            );
        } catch (\Throwable $e) {
            report($e);

            session()->flash(
                'error',
                'NO SE PUDIERON GENERAR LAS PLANILLAS: ' .
                $e->getMessage()
            );
        }

        $this->redirectRoute(
            'personal.asistencias.generar-manualmente'
        );
    }

    public function render()
    {
        return view(
            'livewire.personal.asistencias.generar-manualmente'
        );
    }
}
