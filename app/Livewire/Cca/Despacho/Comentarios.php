<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Vistas\Cca\VtExistenteComentario;
use Livewire\Component;
use Livewire\WithPagination;

class Comentarios extends Component
{
    use WithPagination;

    // Variable recibida desde la ruta
    public $servicio;

    // Propiedad para renderizar los comentarios
    //public $comentarios;

    // Propiedad la paginacion de los comentarios
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

    public function render()
    {
        return view('livewire.cca.despacho.comentarios', [
            'comentarios' => VtExistenteComentario::select('idservicio_existente_comentario', 'comentario', 'nombrecompleto', 'created_at')
                ->where('servicio_id', $this->servicio)
                ->orderBy('created_at', 'desc')
                ->paginate($this->paginadoComentarios, ['*'], 'comentarios_page')
        ]);
    }
}
