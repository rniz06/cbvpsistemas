<?php

namespace App\Livewire\Personal\Asistencias;

use App\Exports\Excel\Personal\Asistencias\ExcelAsistenciasExport;
use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Detalle;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Voluntarios extends Component
{
    use WithPagination;

    // REGISTRO
    public $asistencia;

    // PROPIEDADES DE FILTRADO
    public $buscarNombreCompleto, $buscarCodigo, $paginado = 5;

    // PROPIEDADES PARA EL BLOQUEO
    public $bloqueoBtnCargar = true, $bloquearBtnCargarPorFichaActualizar = false, $bloqueoBtnEnviar = false;

    // PROPIEDADES PARA MENSAJES DE ALERTA PERMANENTE
    public $mostrarMensajeAleta = false;

    # PROPIEDADES PARA EL MODAL DE CARGA DE ASISTENCIA
    public $mostrar_form_carga = false, $detalle = null;

    public function habilitar_form_carga($detalle)
    {
        $this->detalle = $detalle;
        $this->mostrar_form_carga = true;
    }

    public function mount($asistencia)
    {
        // OBTENER REGISTRO ACTUAL
        $this->asistencia = Asistencia::select('id_asistencia', 'compania_id', 'periodo_id', 'estado_id')
            ->with([
                'compania:id_compania,compania',
                'estado:id_asistencia_estado,estado',
                'periodo.anho:id_anho,anho',
                'periodo.mes:id_mes,mes',
            ])->findOrFail($asistencia);

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
            $this->bloquearBtnCargarPorFichaActualizar = true; //OMITIR MOMENTANEAMENTE BLOQUEO POR FASE DE DESARROLLO
        }

        // CONSULTA PARA VERIFICAR QUE NO EXISTEN FICHAS POR CARGAR ASISTENCIA
        $enviar = Detalle::where('asistencia_id', $this->asistencia->id_asistencia)
            ->whereNotNull('total')
            ->exists();

        // COMPROBAR RESULTADO DE LA CONSULTA ANTERIOR
        if ($enviar) {
            $this->bloqueoBtnEnviar = true;
        }

        # SI EL ESTADO ES DISTINTO A "SIN CARGAR", BLOQUEA EL BOTON ENVIAR
        if ($this->asistencia->estado_id != 2) { // SIN CARGAR
            $this->bloqueoBtnEnviar = true;
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

    public function enviar()
    {
        $this->asistencia->update([
            'estado_id' => 3, // REMITIDO P/ VERIFICAR
        ]);
        session()->flash('success', 'Remitido Correctamente!');
        $this->redirectRoute('personal.asistencias.show', $this->asistencia->id_asistencia);
    }

    // Obtener lo datos para los reportes pdf y excel
    public function cargarDatosExport()
    {
        return Detalle::select('id_asistencia_detalle', 'personal_id', 'asistencia_id', 'practica', 'guardia', 'citacion', 'total')
            ->with('personal:idpersonal,nombrecompleto,codigo,estado_actualizar_id')
            ->where('asistencia_id', $this->asistencia->id_asistencia)->get();
    }

    public function excel()
    {
        $detalles = $this->cargarDatosExport();

        return Excel::download(new ExcelAsistenciasExport($this->asistencia, $detalles), 'Asistencia.xlsx');
    }
}
