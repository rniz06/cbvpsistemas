<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal\Asistencia\Detalle;
use Livewire\Component;

class Carga2 extends Component
{
    public $detalle;

    public $practica;
    public $guardia;
    public $citacion;

    public function mount($detalle)
    {
        $this->detalle = Detalle::with([
            'asistencia:id_asistencia,hubo_citacion,tipo_asistencia',
            'personal:idpersonal,nombrecompleto,codigo',
        ])->findOrFail($detalle);

        $this->guardia = $this->detalle->guardia;
        $this->citacion = $this->detalle->citacion;

        $this->practica = $this->esP5()
            ? null
            : $this->detalle->practica;
    }

    private function esP5(): bool
    {
        return $this->detalle->asistencia->tipo_asistencia === 'P5';
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
            'citacion' => [
                $this->detalle->asistencia->hubo_citacion
                    ? 'required'
                    : 'nullable',
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

        return $rules;
    }

    public function guardar()
    {
        $this->validate();

        try {
            $esP5 = $this->esP5();
            $huboCitacion = (bool) $this->detalle->asistencia->hubo_citacion;

            $guardia = round((float) $this->guardia, 2);

            $practica = $esP5
                ? null
                : round((float) $this->practica, 2);

            $citacion = $huboCitacion
                ? round((float) $this->citacion, 2)
                : null;

            if ($esP5) {
                $total = $huboCitacion
                    ? ($guardia + $citacion) / 2
                    : $guardia;
            } else {
                $total = $huboCitacion
                    ? ($practica + $guardia + $citacion) / 3
                    : ($practica + $guardia) / 2;
            }

            $this->detalle->update([
                'practica' => $practica,
                'guardia' => $guardia,
                'citacion' => $citacion,
                'total' => number_format(round($total, 2), 2, '.', ''),
            ]);

            session()->flash(
                'success',
                'ASISTENCIA REGISTRADA CORRECTAMENTE.'
            );
        } catch (\Throwable $e) {
            report($e);

            session()->flash(
                'error',
                'NO SE PUDO REGISTRAR LA ASISTENCIA. Revisá el registro e intentá nuevamente.'
            );
        }

        $this->dispatch('asistencia-cargada');
    }

    public function render()
    {
        return view('livewire.personal.asistencias.carga2');
    }
}