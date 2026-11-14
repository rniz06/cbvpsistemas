<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Detalle;
use Livewire\Component;

class Carga extends Component
{
    public $asistencia;
    public $detalle;
    public $asistencia_detalle_id;

    public $practica;
    public $guardia;
    public $citacion;

    public $bloqueoCitacion = true;

    public function mount($asistencia_detalle_id, $asistencia)
    {
        $this->asistencia_detalle_id = $asistencia_detalle_id;

        $this->asistencia = $asistencia instanceof Asistencia
            ? $asistencia
            : Asistencia::findOrFail($asistencia);

        $this->detalle = Detalle::with(
            'personal:idpersonal,nombrecompleto,codigo'
        )->findOrFail($asistencia_detalle_id);

        $this->practica = $this->esP5()
            ? null
            : $this->detalle->practica;

        $this->guardia = $this->detalle->guardia;
        $this->citacion = $this->detalle->citacion;

        $this->bloqueoCitacion = !$this->asistencia->hubo_citacion;
    }

    private function esP5(): bool
    {
        return $this->asistencia->tipo_asistencia === 'P5';
    }

    protected function rules(): array
    {
        $rules = [
            'guardia' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
                'decimal:0,2',
            ],
        ];

        if (!$this->esP5()) {
            $rules['practica'] = [
                'required',
                'numeric',
                'min:0',
                'max:100',
                'decimal:0,2',
            ];
        }

        if (!$this->bloqueoCitacion) {
            $rules['citacion'] = [
                'required',
                'numeric',
                'min:0',
                'max:100',
                'decimal:0,2',
            ];
        }

        return $rules;
    }

    public function grabar()
    {
        $this->validate();

        $esP5 = $this->esP5();
        $hayCitacion = !$this->bloqueoCitacion;

        $guardia = round((float) $this->guardia, 2);

        $practica = $esP5
            ? null
            : round((float) $this->practica, 2);

        $citacion = $hayCitacion
            ? round((float) $this->citacion, 2)
            : null;

        $total = $this->calcularPromedio(
            $esP5,
            $hayCitacion,
            $practica,
            $guardia,
            $citacion
        );

        $this->detalle->update([
            'practica' => $practica,
            'guardia' => $guardia,
            'citacion' => $citacion,
            'total' => number_format(round($total, 2), 2, '.', ''),
        ]);

        session()->flash(
            'success',
            '¡Asistencia registrada correctamente!'
        );

        return $this->redirectRoute(
            'personal.asistencias.show',
            $this->detalle->asistencia_id
        );
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

    public function render()
    {
        return view('livewire.personal.asistencias.carga');
    }
}