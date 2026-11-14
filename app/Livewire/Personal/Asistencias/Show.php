<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Detalle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    public $asistencia;

    public $bloqueo_enviar_dpto_personal = true;
    public $bloqueo_aprobar_dpto_personal = true;

    public function mount($asistencia)
    {
        $this->asistencia = Asistencia::select(
            'id_asistencia',
            'compania_id',
            'periodo_id',
            'estado_id',
            'hubo_citacion',
            'tipo_asistencia'
        )->with([
            'compania:id_compania,compania',
            'estado:id_asistencia_estado,estado',
            'periodo:id_asistencia_periodo,anho_id,mes_id,fecha_vencimiento',
            'periodo.anho:id_anho,anho',
            'periodo.mes:id_mes,mes',
        ])->findOrFail($asistencia);

        if (in_array((int) $this->asistencia->estado_id, [2, 5], true)) {
            $this->bloqueo_enviar_dpto_personal = false;
        }

        if (in_array((int) $this->asistencia->estado_id, [3, 7], true)) {
            $this->bloqueo_aprobar_dpto_personal = false;
        }
    }

    public function yaFueRemitida(): bool
    {
        return in_array((int) $this->asistencia->estado_id, [3, 4, 7], true);
    }

    public function estadoPlazo(): string
    {
        if ($this->yaFueRemitida()) {
            return 'YA SE REMITIÓ';
        }

        $fechaVencimiento = $this->asistencia->periodo?->fecha_vencimiento;

        if (!$fechaVencimiento) {
            return 'SIN FECHA DEFINIDA';
        }

        return now()->startOfDay()->lte(
            \Carbon\Carbon::parse($fechaVencimiento)->startOfDay()
        ) ? 'EN PLAZO' : 'FUERA DE PLAZO';
    }

    public function render()
    {
        return view('livewire.personal.asistencias.show');
    }

    public function enviarDptoPersonal()
    {
        $this->asistencia->update([
            'estado_id' => 3,
        ]);

        session()->flash(
            'success',
            'La planilla de asistencia fue remitida al Departamento de Personal con éxito.'
        );

        return redirect()->route(
            'personal.asistencias.show',
            $this->asistencia->id_asistencia
        );
    }

    public function aprobarDptoPersonal()
    {
        $this->asistencia->update([
            'estado_id' => 4,
        ]);

        session()->flash(
            'success',
            'La planilla de asistencia fue remitida a la Comandancia con éxito.'
        );

        return redirect()->route(
            'personal.asistencias.show',
            $this->asistencia->id_asistencia
        );
    }

    public function habilitar_citacion()
    {
        DB::transaction(function () {
            $this->asistencia->update([
                'hubo_citacion' => true,
            ]);

            $esP5 = $this->asistencia->tipo_asistencia === 'P5';

            $totalSql = $esP5
                ? 'ROUND(COALESCE(guardia, 0) / 2, 2)'
                : 'ROUND((COALESCE(practica, 0) + COALESCE(guardia, 0)) / 3, 2)';

            Detalle::where(
                'asistencia_id',
                $this->asistencia->id_asistencia
            )->update([
                'citacion' => 0,
                'total' => DB::raw($totalSql),
            ]);
        });

        session()->flash('success', 'SE HABILITÓ EL CAMPO DE CITACIÓN.');

        return redirect()->route(
            'personal.asistencias.show',
            $this->asistencia->id_asistencia
        );
    }

    public function cancelar_citacion()
    {
        DB::transaction(function () {
            $this->asistencia->update([
                'hubo_citacion' => false,
            ]);

            $esP5 = $this->asistencia->tipo_asistencia === 'P5';

            $totalSql = $esP5
                ? 'ROUND(COALESCE(guardia, 0), 2)'
                : 'ROUND((COALESCE(practica, 0) + COALESCE(guardia, 0)) / 2, 2)';

            Detalle::where(
                'asistencia_id',
                $this->asistencia->id_asistencia
            )->update([
                'citacion' => null,
                'total' => DB::raw($totalSql),
            ]);
        });

        session()->flash('success', 'SE CANCELÓ EL CAMPO DE CITACIÓN.');

        return redirect()->route(
            'personal.asistencias.show',
            $this->asistencia->id_asistencia
        );
    }
}