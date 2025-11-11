<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Detalle;
use Livewire\Component;
use Livewire\WithPagination;

class Voluntarios extends Component
{
    use WithPagination;

    // REGISTRO
    public $asistencia;

    // PROPIEDADES DE FILTRADO
    public $buscarNombreCompleto, $buscarCodigo, $paginado = 5;

    // PROPIEDADES PARA EL BLOQUEO
    public $bloqueoBtnCargar = true, $bloquearBtnCargarPorFichaActualizar = false;

    // PROPIEDADES PARA MENSAJES DE ALERTA PERMANENTE
    public $mostrarMensajeAleta = false;

    public function mount($asistencia)
    {
        // OBTENER REGISTRO ACTUAL
        $this->asistencia = Asistencia::findOrfail($asistencia);

        # SI EL ESTADO ES "SIN CARGAR" HABILITA BTN PARA LA CARGA, SI ES DISTINTO PERMANECE BLOQUEADO
        if ($this->asistencia->estado_id == 2) { // SIN CARGAR
            $this->bloqueoBtnCargar = false;
        }

        // CONSULTA PARA VERIFICAR QUE NO EXISTEN FICHAS QUE FALTEN ACTUALIZAR
        $pendiente = Detalle::where('asistencia_id', $this->asistencia->id_asistencia)
            ->whereRelation('personal', 'estado_actualizar_id', 1)
            ->exists();

        // COMPROBAR RESULTADO DE LA CONSULTA ANTERIOR
        if ($pendiente) {
            //session()->flash('danger', 'EXISTEN FICHAS NO ACTUALIZADAS.');
            $this->mostrarMensajeAleta = true;
            $this->bloquearBtnCargarPorFichaActualizar = true;
        }
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscarNombreCompleto',
            'buscarCodigo',
            'paginado'
        ])) {
            $this->resetPage('personales_page');
        }
    }

    public function render()
    {
        return view('livewire.personal.asistencias.voluntarios', [
            'voluntarios' => Detalle::select('id_asistencia_detalle', 'personal_id', 'asistencia_id', 'practica', 'guardia', 'citacion', 'total')
                ->with('personal:idpersonal,nombrecompleto,codigo,estado_actualizar_id')
                ->where('asistencia_id', $this->asistencia->id_asistencia)
                ->buscarNombrecompleto($this->buscarNombreCompleto)
                ->buscarCodigo($this->buscarCodigo)
                ->paginate($this->paginado, ['*'], 'personales_page')
        ]);
    }
}
