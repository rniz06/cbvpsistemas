<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Vistas\Cca\VtExistenteComentario;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Comentarios extends Component
{
    use WithPagination;

    // Variable recibida desde la ruta
    public $servicio;

    // Propiedad para renderizar los comentarios
    //public $comentarios;

    // Propiedad la paginacion de los comentarios
    public $mostrarFormAgregarComentario = false;
    public $paginadoComentarios = 5;

    public function mount()
    {
        //
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'paginadoComentarios',
        ])) {
            $this->resetPage('comentarios_page');
        }
    }

    public function mostrarFormAgregarComentario()
    {
        $this->mostrarFormAgregarComentario = true;
    }

    // Escucha el evento cerrar-formulario-comentario para cerrar el formulario
    #[On('cerrar-formulario-comentario')]
    public function mostrarFormAgregarComentarioClose()
    {
        $this->mostrarFormAgregarComentario = false;
    }

    // Escucha el evento comentario-agregado para recargar los comentarios
    #[On('comentario-agregado')]
    public function cargarComentarios()
    {
        return VtExistenteComentario::select('idservicio_existente_comentario', 'comentario', 'nombrecompleto', 'created_at')
            ->where('servicio_id', $this->servicio)
            ->orderByDesc('created_at')
            ->paginate($this->paginadoComentarios, ['*'], 'comentarios_page');
    }

    public function render()
    {
        return view('livewire.cca.despacho.comentarios', [
            'comentarios' => $this->cargarComentarios()
        ]);
    }
}
