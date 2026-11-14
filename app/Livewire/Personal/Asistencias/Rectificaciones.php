<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal;
use App\Models\Personal\Asistencia\Detalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Rectificaciones extends Component
{
    public $buscar = '';

    public $personalSeleccionadoId = null;

    public $detalleEnEdicionId = null;

    public $detalleHistorialId = null;

    public $practica;
    public $guardia;
    public $citacion;

    public $observacion = '';

    public function seleccionarPersonal($id)
    {
        $personal = Personal::findOrFail($id);

        $this->personalSeleccionadoId = $personal->idpersonal;

        $this->detalleEnEdicionId = null;
        $this->detalleHistorialId = null;

        $this->resetFormulario();
        $this->buscar = '';
    }

    public function cambiarPersonal()
    {
        $this->personalSeleccionadoId = null;
        $this->detalleEnEdicionId = null;
        $this->detalleHistorialId = null;

        $this->resetFormulario();
    }

    public function editar($id)
    {
        $detalle = Detalle::with([
            'asistencia.estado',
        ])
            ->where('personal_id', $this->personalSeleccionadoId)
            ->findOrFail($id);

        $this->verificarPlanillaAprobada($detalle);

        $this->detalleEnEdicionId = $detalle->id_asistencia_detalle;
        $this->detalleHistorialId = null;

        $this->practica = $detalle->practica;
        $this->guardia = $detalle->guardia;
        $this->citacion = $detalle->citacion;

        $this->observacion = '';
    }

    public function guardar()
    {
        if (!$this->detalleEnEdicionId) {
            return;
        }

        $detalleActual = Detalle::with([
            'asistencia.estado',
        ])
            ->where('personal_id', $this->personalSeleccionadoId)
            ->findOrFail($this->detalleEnEdicionId);

        $this->verificarPlanillaAprobada($detalleActual);

        $esP5 = $detalleActual->asistencia->tipo_asistencia === 'P5';
        $hayCitacion = (bool) $detalleActual->asistencia->hubo_citacion;

        $rules = [
            'guardia' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
                'decimal:0,2',
            ],
            'observacion' => [
                'required',
                'string',
                'min:5',
                'max:1000',
            ],
        ];

        if (!$esP5) {
            $rules['practica'] = [
                'required',
                'numeric',
                'min:0',
                'max:100',
                'decimal:0,2',
            ];
        }

        if ($hayCitacion) {
            $rules['citacion'] = [
                'required',
                'numeric',
                'min:0',
                'max:100',
                'decimal:0,2',
            ];
        }

        $this->validate($rules);

        $guardia = round((float) $this->guardia, 2);

        $practica = $esP5
            ? null
            : round((float) $this->practica, 2);

        $citacion = $hayCitacion
            ? round((float) $this->citacion, 2)
            : null;

        $total = round($this->calcularPromedio(
            $esP5,
            $hayCitacion,
            $practica,
            $guardia,
            $citacion
        ), 2);

        DB::transaction(function () use (
            $practica,
            $guardia,
            $citacion,
            $total
        ) {
            $detalle = Detalle::with([
                'asistencia.estado',
            ])
                ->where('personal_id', $this->personalSeleccionadoId)
                ->lockForUpdate()
                ->findOrFail($this->detalleEnEdicionId);

            $this->verificarPlanillaAprobada($detalle);

            $valoresAnteriores = [
                'practica' => $detalle->practica,
                'guardia' => $detalle->guardia,
                'citacion' => $detalle->citacion,
                'total' => $detalle->total,
            ];

            $valoresNuevos = [
                'practica' => $practica !== null
                    ? number_format($practica, 2, '.', '')
                    : null,
                'guardia' => number_format($guardia, 2, '.', ''),
                'citacion' => $citacion !== null
                    ? number_format($citacion, 2, '.', '')
                    : null,
                'total' => number_format($total, 2, '.', ''),
            ];

            DB::table('PER_asistencias_rectificaciones')->insert([
                'asistencia_detalle_id' => $detalle->id_asistencia_detalle,
                'asistencia_id' => $detalle->asistencia_id,
                'personal_id' => $detalle->personal_id,
                'usuario_id' => Auth::id(),
                'observacion' => $this->observacion,
                'valores_anteriores' => json_encode(
                    $valoresAnteriores,
                    JSON_THROW_ON_ERROR
                ),
                'valores_nuevos' => json_encode(
                    $valoresNuevos,
                    JSON_THROW_ON_ERROR
                ),
                'created_at' => now(),
            ]);

            $detalle->update($valoresNuevos);
        });

        $this->detalleEnEdicionId = null;
        $this->resetFormulario();

        session()->flash(
            'success',
            'La asistencia fue rectificada correctamente y el cambio quedó registrado en el historial.'
        );
    }

    public function verHistorial($id)
    {
        $detalle = Detalle::where(
            'personal_id',
            $this->personalSeleccionadoId
        )->findOrFail($id);

        $this->detalleEnEdicionId = null;
        $this->resetFormulario();

        $this->detalleHistorialId =
            $this->detalleHistorialId == $id ? null : $id;
    }

    public function cerrarHistorial()
    {
        $this->detalleHistorialId = null;
    }

    public function cancelarEdicion()
    {
        $this->detalleEnEdicionId = null;
        $this->resetFormulario();
    }

    private function verificarPlanillaAprobada(Detalle $detalle): void
    {
        $estado = mb_strtoupper(
            (string) $detalle->asistencia?->estado?->estado
        );

        if (!str_contains($estado, 'APROB')) {
            throw ValidationException::withMessages([
                'guardia' => 'Esta asistencia no pertenece a una planilla aprobada y no puede rectificarse.',
            ]);
        }
    }

    private function calcularPromedio(
        bool $esP5,
        bool $hayCitacion,
        ?float $practica,
        float $guardia,
        ?float $citacion
    ): float {
        if ($esP5) {
            return $hayCitacion
                ? ($guardia + $citacion) / 2
                : $guardia;
        }

        return $hayCitacion
            ? ($practica + $guardia + $citacion) / 3
            : ($practica + $guardia) / 2;
    }

    private function resetFormulario(): void
    {
        $this->practica = null;
        $this->guardia = null;
        $this->citacion = null;
        $this->observacion = '';
    }

    public function render()
    {
        $personal = null;
        $personalEncontrado = collect();
        $detalles = collect();
        $historiales = collect();

        if (
            mb_strlen(trim($this->buscar)) >= 2 &&
            !$this->personalSeleccionadoId
        ) {
            $termino = trim($this->buscar);

            $personalEncontrado = Personal::query()
                ->with('compania')
                ->select(
                    'idpersonal',
                    'nombrecompleto',
                    'codigo',
                    'compania_id'
                )
                ->where(function ($query) use ($termino) {
                    $query->where('codigo', 'like', "%{$termino}%")
                        ->orWhere(
                            'nombrecompleto',
                            'like',
                            "%{$termino}%"
                        );
                })
                ->orderBy('nombrecompleto')
                ->limit(20)
                ->get();
        }

        if ($this->personalSeleccionadoId) {
            $personal = Personal::query()
                ->with('compania')
                ->select(
                    'idpersonal',
                    'nombrecompleto',
                    'codigo',
                    'compania_id'
                )
                ->findOrFail($this->personalSeleccionadoId);

            $detalles = Detalle::query()
                ->with([
                    'asistencia.compania',
                    'asistencia.estado',
                    'asistencia.periodo.anho',
                    'asistencia.periodo.mes',
                ])
                ->where(
                    'personal_id',
                    $this->personalSeleccionadoId
                )
                ->whereHas('asistencia.estado', function ($query) {
                    $query->whereRaw(
                        'UPPER(estado) LIKE ?',
                        ['%APROB%']
                    );
                })
                ->whereHas('asistencia')
                ->orderByDesc('asistencia_id')
                ->get();

            if ($this->detalleHistorialId) {
                $historiales = DB::table(
                    'PER_asistencias_rectificaciones'
                )
                    ->where(
                        'asistencia_detalle_id',
                        $this->detalleHistorialId
                    )
                    ->where(
                        'personal_id',
                        $this->personalSeleccionadoId
                    )
                    ->orderByDesc('created_at')
                    ->get();
            }
        }

        return view(
            'livewire.personal.asistencias.rectificaciones',
            compact(
                'personal',
                'personalEncontrado',
                'detalles',
                'historiales'
            )
        );
    }
}