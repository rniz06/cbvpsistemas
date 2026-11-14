<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Gral\Anho;
use App\Models\Gral\Mes;
use App\Models\Personal\Asistencia\Periodo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CrearPeriodo extends Component
{
    public $anho_id = '';
    public $mes_id = '';
    public $fecha_vencimiento = '';

    public $anhos = [];
    public $meses = [];

    public function mount(): void
    {
        $this->anhos = Anho::orderByDesc('anho')->get();
        $this->meses = Mes::orderBy('numero')->get();

        $this->calcularVencimiento();
    }

    public function updatedAnhoId(): void
    {
        $this->calcularVencimiento();
    }

    public function updatedMesId(): void
    {
        $this->calcularVencimiento();
    }

    /**
     * Propone el día 5 del mes siguiente.
     *
     * Si el día 5 cae sábado o domingo, extiende
     * dos días hábiles a partir de esa fecha.
     *
     * Los feriados deberán contemplarse mediante
     * un calendario de feriados para automatizar
     * también ese supuesto.
     */
    public function calcularVencimiento(): void
    {
        $this->fecha_vencimiento = '';

        if (!$this->anho_id || !$this->mes_id) {
            return;
        }

        $anho = Anho::find($this->anho_id);
        $mes = Mes::find($this->mes_id);

        if (!$anho || !$mes) {
            return;
        }

        $numeroMes = (int) $mes->numero;
        $numeroAnho = (int) $anho->anho;

        if ($numeroMes < 1 || $numeroMes > 12) {
            return;
        }

        $fecha = Carbon::create(
            $numeroAnho,
            $numeroMes,
            1
        )->addMonth()->day(5);

        if ($fecha->isWeekend()) {
            $diasHabiles = 0;

            while ($diasHabiles < 2) {
                $fecha->addDay();

                if (!$fecha->isWeekend()) {
                    $diasHabiles++;
                }
            }
        }

        $this->fecha_vencimiento = $fecha->format('Y-m-d');
    }

    protected function rules(): array
    {
        return [
            'anho_id' => [
                'required',
                'integer',
                Rule::exists('GRAL_anhos', 'id_anho'),
            ],
            'mes_id' => [
                'required',
                'integer',
                Rule::exists('GRAL_meses', 'id_mes')
                    ->whereNull('deleted_at'),
            ],
            'fecha_vencimiento' => [
                'required',
                'date_format:Y-m-d',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'anho_id.required' => 'Seleccioná un año.',
            'mes_id.required' => 'Seleccioná un mes.',
            'fecha_vencimiento.required' =>
                'Indicá la fecha límite de presentación.',
            'fecha_vencimiento.date_format' =>
                'La fecha límite no tiene un formato válido.',
        ];
    }

    public function guardar(): void
    {
        $datos = $this->validate();

        $existe = Periodo::where('anho_id', $datos['anho_id'])
            ->where('mes_id', $datos['mes_id'])
            ->exists();

        if ($existe) {
            $this->addError(
                'mes_id',
                'Ya existe un período para ese año y mes.'
            );

            return;
        }

        DB::transaction(function () use ($datos) {
            Periodo::create([
                'anho_id' => $datos['anho_id'],
                'mes_id' => $datos['mes_id'],
                'fecha_vencimiento' => $datos['fecha_vencimiento'],
            ]);
        });

        session()->flash(
            'success',
            'El período se creó correctamente con su fecha límite de presentación.'
        );

        $this->redirectRoute('personal.asistencias.crear-periodo');
    }

    public function render()
    {
        return view(
            'livewire.personal.asistencias.crear-periodo'
        );
    }
}
