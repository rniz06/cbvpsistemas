<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Cca\Servicios\Apoyo;
use App\Models\Vistas\Cca\VtExistenteApoyo;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Apoyos extends Component
{
    use WithPagination;

    // Variable recibida desde la ruta
    public $servicio;

    // Propiedad la paginacion de los comentarios
    public $mostrarFormAgregarApoyo = false;
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

    public function mostrarFormAgregarComentario()
    {
        $this->mostrarFormAgregarApoyo = true;
    }

    // Escucha el evento cerrar-formulario-apoyo para cerrar el formulario
    #[On('cerrar-formulario-apoyo')]
    public function mostrarFormAgregarComentarioClose()
    {
        $this->mostrarFormAgregarApoyo = false;
    }

    // Escucha el evento comentario-agregado para recargar los comentarios
    #[On('apoyo-agregado')]
    public function cargarApoyos()
    {
        return VtExistenteApoyo::select(
            'idservicio_existente_apoyo',
            'compania',
            'movil',
            'tipo',
            'nombrecompleto',
            'chofer',
            'cantidad_tripulantes',
            'fecha_cia',
            'fecha_movil',
            'fecha_servicio',
            'fecha_base'
        )
            ->where('servicio_id', $this->servicio)
            ->orderByDesc('created_at')
            ->paginate($this->paginadoApoyos, ['*'], 'apoyos_page');
    }

    public function horaAccion($accion)
    {
        switch ($accion) {
            case '1':
                $apoyo = Apoyo::where('servicio_id', $this->servicio)->update([
                    'fecha_cia' => now(),
                ]);
                $mensaje = 'Llegada de Cia Accionada Correctamente!';
                break;

            case '2':
                $apoyo = Apoyo::where('servicio_id', $this->servicio)->update([
                    'fecha_movil' => now(),
                ]);
                $mensaje = 'Salida de Móvil Accionada Correctamente!';
                break;

            case '3':
                $apoyo = Apoyo::where('servicio_id', $this->servicio)->update([
                    'fecha_servicio' => now(),
                ]);
                $mensaje = 'Llegada de Móvil Accionada Correctamente!';
                break;

            case '4':
                $apoyo = Apoyo::where('servicio_id', $this->servicio)->update([
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
        return view('livewire.cca.despacho.apoyos', [
            'apoyos' => $this->cargarApoyos()
        ]);
    }
}
