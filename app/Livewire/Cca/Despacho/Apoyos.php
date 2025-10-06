<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Cca\Servicios\Apoyo;
use App\Models\Vistas\Cca\VtExistenteApoyo;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Apoyos extends Component
{
    use WithPagination;

    // Variable recibida desde la ruta
    public $servicio;

    public $apoyo_seleccionado_id = null;

    // Propiedad la paginacion de los comentarios
    public $mostrarFormAgregarApoyo = false;
    public $mostrarFormAgregarDetalle = false;
    public $paginadoApoyos = 5;

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'paginadoApoyos',
        ])) {
            $this->resetPage('apoyos_page');
        }
    }

    public function mostrarFormAgregarDetalleFuntion($id)
    {
        // Si ya está visible y el ID es el mismo, ocultar
        if ($this->mostrarFormAgregarDetalle && $this->apoyo_seleccionado_id === $id) {
            $this->mostrarFormAgregarDetalle = false;
            $this->apoyo_seleccionado_id = null;
        } else {
            $this->mostrarFormAgregarDetalle = true;
            $this->apoyo_seleccionado_id = $id;
        }
    }

    public function mostrarFormAgregarApoyo()
    {
        $this->mostrarFormAgregarApoyo = true;
    }

    // Escucha el evento cerrar-formulario-apoyo para cerrar el formulario
    #[On('cerrar-formulario-apoyo')]
    public function mostrarFormAgregarApoyoClose()
    {
        $this->mostrarFormAgregarApoyo = false;
    }

    public function horaAccion($accion, $apoyoId)
    {
        $apoyo =  Apoyo::findOrFail($apoyoId);
        switch ($accion) {
            case '1':
                $apoyo->update([
                    'fecha_cia' => now(),
                ]);
                $mensaje = 'Llegada de Compañia Accionada Correctamente!';
                break;

            case '2':
                $apoyo->update([
                    'fecha_movil' => now(),
                ]);
                $mensaje = 'Salida de Móvil Accionada Correctamente!';
                break;

            case '3':
                $apoyo->update([
                    'fecha_servicio' => now(),
                ]);
                $mensaje = 'Llegada de Móvil Accionada Correctamente!';
                break;

            case '4':
                $apoyo->update([
                    'fecha_base' => now(),
                ]);
                $mensaje = 'Móvil en base Accionada Correctamente!';
                break;
        }

        return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $this->servicio])
            ->with('success', $mensaje);
    }

    public function render()
    {
        $apoyos = VtExistenteApoyo::select(
            'idservicio_existente_apoyo',
            'compania',
            'movil',
            'tipo',
            // Acargo: si es null usar acargo_aux
            DB::raw("
                CASE 
                    WHEN acargo_rentado = 1 THEN 'RENTADO'
                    WHEN acargo_rentado = 0 AND acargo_nombrecompleto IS NOT NULL AND acargo_codigo IS NOT NULL 
                        THEN CONCAT(LEFT(acargo_categoria, 1), '-', acargo_codigo)
                    ELSE acargo_aux
                END AS acargo
                "),
            // Chofer: condiciones según chofer_rentado
            DB::raw("
                CASE 
                    WHEN chofer_rentado = 1 THEN 'RENTADO'
                    WHEN chofer_rentado = 0 AND chofer_nombrecompleto IS NOT NULL AND chofer_codigo IS NOT NULL 
                        THEN CONCAT(LEFT(chofer_categoria, 1), '-', chofer_codigo)
                    ELSE chofer_aux
                END AS chofer
                "),
            'cantidad_tripulantes',
            'fecha_cia',
            'fecha_movil',
            'fecha_servicio',
            'fecha_base',
            'km_final',
            'desperfecto'
        )
            ->where('servicio_existente_id', $this->servicio)
            ->orderByDesc('created_at')
            ->paginate($this->paginadoApoyos, ['*'], 'apoyos_page');

        return view('livewire.cca.despacho.apoyos', compact('apoyos'));
    }
}
