<?php

namespace App\Livewire\Cca\Despacho;

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

    public function render()
    {
        return view('livewire.cca.despacho.apoyos', [
            'apoyos' => $this->cargarApoyos()
        ]);
    }
}
