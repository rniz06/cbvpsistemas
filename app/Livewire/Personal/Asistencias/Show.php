<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Detalle;
use Livewire\Component;

class Show extends Component
{
    public $asistencia;

    public $bloqueo_enviar_dpto_personal = true, $bloqueo_aprobar_derivar_comandancia = true, $bloqueo_aprobar_comandancia = true;

    public function mount($asistencia)
    {
        $this->asistencia = Asistencia::select('id_asistencia', 'compania_id', 'periodo_id', 'estado_id')
            ->with([
                'compania:id_compania,compania',
                'estado:id_asistencia_estado,estado',
                'periodo.anho:id_anho,anho',
                'periodo.mes:id_mes,mes',
            ])->findOrFail($asistencia);

        # Comprobar si ya se cargo la totalidad de la asistencia
        $se_cargo_total = Detalle::where('asistencia_id', $this->asistencia->id_asistencia)
            ->whereNotNull('total')
            ->exists();

        if ($this->asistencia->estado_id == 2 or $this->asistencia->estado_id == 5) { // ESTADO: SIN CARGAR - RECHAZADO POR PERSONAL
            // Si no existen fichas por cargar asistencia se habilita el btn
            if (!$se_cargo_total) {
                $this->bloqueo_enviar_dpto_personal = false;
            }
        }

        # Bloqueo Btn Aprobar y Derivar al Dpto de Personal
        if ($this->asistencia->estado_id == 3 or $this->asistencia->estado_id == 7) { // ESTADO: REMITIDO P/ VERIFICAR - RECHAZADO POR COMANDANCIA
            // Si no existen fichas por cargar asistencia se habilita el btn
            if (!$se_cargo_total) {
                $this->bloqueo_aprobar_derivar_comandancia = false;
            }
        }

        # Bloqueo Btn Aprobado por Comandancia
        if ($this->asistencia->estado_id == 4) { // ESTADO: APROBADO POR PERSONAL
            // Si no existen fichas por cargar asistencia se habilita el btn
            if (!$se_cargo_total) {
                $this->bloqueo_aprobar_comandancia = false;
            }
        }
    }

    public function render()
    {
        return view('livewire.personal.asistencias.show');
    }

    public function enviarDptoPersonal()
    {
        $this->asistencia->update([
            'estado_id' => 3, # ESTADO: REMITIDO P/ VERIFICAR
        ]);

        session()->flash('success', 'La planilla de asistencia fue remitida al Departamento de Personal con éxito.');
        return redirect()->route('personal.asistencias.show', $this->asistencia->id_asistencia);
    }

    public function aprobarDerivarComandancia()
    {
        $this->asistencia->update([
            'estado_id' => 4, # ESTADO: APROBADO POR PERSONAL
        ]);

        session()->flash('success', 'La planilla de asistencia fue remitida al Comandancia con éxito.');
        return redirect()->route('personal.asistencias.show', $this->asistencia->id_asistencia);
    }

    public function rechazarDerivarCompania()
    {
        $this->asistencia->update([
            'estado_id' => 5, # ESTADO: RECHAZADO POR PERSONAL
        ]);

        session()->flash('success', 'La planilla de asistencia fue rechazada y remitida a la Compañia.');
        return redirect()->route('personal.asistencias.show', $this->asistencia->id_asistencia);
    }

    public function aprobadoComandancia()
    {
        $this->asistencia->update([
            'estado_id' => 6, # ESTADO: APROBADO POR COMANDANCIA
        ]);

        session()->flash('success', 'La planilla de asistencia fue remitida al Comandancia con éxito.');
        return redirect()->route('personal.asistencias.show', $this->asistencia->id_asistencia);
    }

    public function rechazarDerivarDptoPersonal()
    {
        $this->asistencia->update([
            'estado_id' => 7, # ESTADO: RECHAZADO POR COMANDANCIA
        ]);

        session()->flash('success', 'La planilla de asistencia fue remitida al Comandancia con éxito.');
        return redirect()->route('personal.asistencias.show', $this->asistencia->id_asistencia);
    }
}
