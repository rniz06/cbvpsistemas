<?php

namespace App\Livewire\Perfil;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MiPorcentaje extends Component
{
    public string $anioSeleccionado = '';
    public string $periodoDesde = '1';
    public string $periodoHasta = '12';

    public function mount(): void
    {
        $this->cargarAnioInicial();
    }

    /**
     * Obtiene exclusivamente los años donde el usuario
     * tiene al menos un detalle individual de asistencia.
     */
    private function obtenerAnios()
    {
        $personalId = Auth::user()?->personal_id;

        if (!$personalId) {
            return collect();
        }

        return DB::table('PER_asistencias_detalles as d')
            ->join(
                'PER_asistencias as a',
                'a.id_asistencia',
                '=',
                'd.asistencia_id'
            )
            ->join(
                'PER_asistencias_periodos as p',
                'p.id_asistencia_periodo',
                '=',
                'a.periodo_id'
            )
            ->join(
                'GRAL_anhos as an',
                'an.id_anho',
                '=',
                'p.anho_id'
            )
            ->where('d.personal_id', $personalId)
            ->whereNull('d.deleted_at')
            ->whereNull('a.deleted_at')
            ->whereIn('a.tipo_asistencia', ['P4', 'P5'])
            ->select(
                'an.id_anho',
                'an.anho'
            )
            ->distinct()
            ->orderByDesc('an.anho')
            ->get();
    }

    private function cargarAnioInicial(): void
    {
        $anios = $this->obtenerAnios();

        if ($anios->isNotEmpty()) {
            $this->anioSeleccionado = (string) $anios->first()->id_anho;
        }
    }

    public function updatedAnioSeleccionado(): void
    {
        // Livewire vuelve a ejecutar render con el nuevo año.
    }

    public function render()
    {
        $personalId = Auth::user()?->personal_id;

        $anios = $this->obtenerAnios();

        $registros = collect();

        $promedio = null;
        $cantidadPeriodos = 0;
        $cantidadConPorcentaje = 0;

        if (
            $personalId
            && $this->anioSeleccionado !== ''
            && $anios->contains(
                'id_anho',
                (int) $this->anioSeleccionado
            )
        ) {
            $desde = max(1, min(12, (int) $this->periodoDesde));
            $hasta = max(1, min(12, (int) $this->periodoHasta));

            if ($desde > $hasta) {
                [$desde, $hasta] = [$hasta, $desde];
            }

            /*
             * CONSULTA PRINCIPAL
             *
             * Parte del detalle individual del usuario.
             *
             * No utiliza:
             * - La compañía actual.
             * - La categoría actual.
             * - La cantidad general de planillas P4/P5.
             *
             * P4/P5 se obtiene de la planilla donde realmente
             * fue registrado el detalle individual.
             */

            $filas = DB::table('PER_asistencias_detalles as d')
                ->join(
                    'PER_asistencias as a',
                    'a.id_asistencia',
                    '=',
                    'd.asistencia_id'
                )
                ->join(
                    'PER_asistencias_periodos as p',
                    'p.id_asistencia_periodo',
                    '=',
                    'a.periodo_id'
                )
                ->join(
                    'GRAL_anhos as an',
                    'an.id_anho',
                    '=',
                    'p.anho_id'
                )
                ->join(
                    'GRAL_meses as m',
                    'm.id_mes',
                    '=',
                    'p.mes_id'
                )
                ->leftJoin(
                    'PER_asistencias_estados as e',
                    'e.id_asistencia_estado',
                    '=',
                    'a.estado_id'
                )
                ->where('d.personal_id', $personalId)
                ->whereNull('d.deleted_at')
                ->whereNull('a.deleted_at')
                ->where('p.anho_id', $this->anioSeleccionado)
                ->whereBetween('m.numero', [$desde, $hasta])
                ->whereIn('a.tipo_asistencia', ['P4', 'P5'])
                ->select([
                    'd.id_asistencia_detalle',
                    'd.asistencia_id',
                    'd.personal_id',
                    'd.practica',
                    'd.guardia',
                    'd.citacion',
                    'd.total',

                    'a.id_asistencia',
                    'a.tipo_asistencia',
                    'a.estado_id',

                    'p.id_asistencia_periodo',
                    'p.anho_id',
                    'p.mes_id',

                    'an.anho',
                    'm.mes',
                    'm.numero as numero_mes',

                    'e.estado as estado_planilla',
                ])
                ->orderBy('m.numero')
                ->orderByDesc('d.id_asistencia_detalle')
                ->get();

            /*
             * UN SOLO REGISTRO POR MES
             *
             * Si por algún dato histórico hubiera más de un detalle
             * del mismo usuario para el mismo año y mes, se conserva
             * el último detalle registrado.
             *
             * La selección se hace después de consultar exclusivamente
             * los detalles del usuario.
             */

            $registros = $filas
                ->groupBy(function ($fila) {
                    return $fila->anho_id . '-' . $fila->mes_id;
                })
                ->map(function ($grupo) {
                    return $grupo->sortByDesc(
                        'id_asistencia_detalle'
                    )->first();
                })
                ->sortBy('numero_mes')
                ->values();

            /*
             * PROMEDIO
             *
             * Se utiliza el total almacenado por el sistema.
             * No se recalculan las fórmulas P4/P5.
             * Los NULL se excluyen, pero los ceros sí cuentan.
             */

            $valores = $registros
                ->filter(function ($registro) {
                    return $registro->total !== null
                        && is_numeric($registro->total);
                })
                ->map(function ($registro) {
                    return (float) $registro->total;
                });

            $cantidadPeriodos = $registros->count();
            $cantidadConPorcentaje = $valores->count();

            if ($cantidadConPorcentaje > 0) {
                $promedio = round($valores->avg(), 2);
            }
        }

        return view('livewire.perfil.mi-porcentaje', [
            'anios' => $anios,
            'registros' => $registros,
            'promedio' => $promedio,
            'cantidadPeriodos' => $cantidadPeriodos,
            'cantidadConPorcentaje' => $cantidadConPorcentaje,
        ]);
    }
}
