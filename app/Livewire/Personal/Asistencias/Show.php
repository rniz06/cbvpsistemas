<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Detalle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    public $asistencia;

    public $bloqueo_enviar_dpto_personal = true, $bloqueo_aprobar_dpto_personal = true;

    public function mount($asistencia)
    {
        $this->asistencia = Asistencia::select('id_asistencia', 'compania_id', 'periodo_id', 'estado_id', 'hubo_citacion')
            ->with([
                'compania:id_compania,compania',
                'estado:id_asistencia_estado,estado',
                'periodo.anho:id_anho,anho',
                'periodo.mes:id_mes,mes',
            ])->findOrFail($asistencia);

        if ($this->asistencia->estado_id == 2 or $this->asistencia->estado_id == 5) { // ESTADO: SIN CARGAR - RECHAZADO POR PERSONAL
            $this->bloqueo_enviar_dpto_personal = false;
        }

        # Bloqueo Btn Aprobar y Derivar al Dpto de Personal
        if ($this->asistencia->estado_id == 3 or $this->asistencia->estado_id == 7) { // ESTADO: REMITIDO P/ VERIFICAR - RECHAZADO POR COMANDANCIA
            $this->bloqueo_aprobar_dpto_personal = false;
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

    public function aprobarDptoPersonal()
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

    # HABILITAR CAMPO CITACION PARA CARGA
    public function habilitar_citacion()
    {

        DB::transaction(function () {
            # ACTUALIZAR LA TABLA DE CABECERA
            $this->asistencia->update([
                'hubo_citacion' => true,
            ]);

            # INICIALIZAR EL CAMPO CITACION EN 0
            Detalle::where('asistencia_id', $this->asistencia->id_asistencia)->update([
                'citacion' => 0
            ]);
        });

        session()->flash('success', 'SE HABILITO EL CAMPO DE CITACIÓN.');
        return redirect()->route('personal.asistencias.show', $this->asistencia->id_asistencia);
    }

    # CANCELAR CAMPO CITACION PARA CARGA
    public function cancelar_citacion()
    {
        DB::transaction(function () {
            # ACTUALIZAR LA TABLA DE CABECERA
            $this->asistencia->update([
                'hubo_citacion' => false,
            ]);

            # ACTUALIZAR EL CAMPO CITACION A NULL
            Detalle::where('asistencia_id', $this->asistencia->id_asistencia)->update([
                'citacion' => null
            ]);
        });

        session()->flash('success', 'SE CANCELO EL CAMPO DE CITACIÓN');
        return redirect()->route('personal.asistencias.show', $this->asistencia->id_asistencia);
    }
}
