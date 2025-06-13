<?php

namespace App\Livewire\Materiales\EquipoHidraulico;

use App\Models\Vistas\Materiales\VtHidraulico;
use App\Models\Vistas\Materiales\VtHidraulicoComentario;
use App\Models\Vistas\Materiales\VtHidraulicoHerr;
use Livewire\Component;
use Livewire\WithPagination;

class Ficha extends Component
{
    use WithPagination;

    public $hidraulico_id;
    public $paginadoHerramientas = 5;
    public $paginadoComentarios = 5;
    public $mostrarFormAgregarAccion = false;

    // Limpiar la paginación al cambiar de pagina
    public function updating($key): void
    {
        if ($key === 'paginadoHerramientas' || $key === 'paginadoComentarios') {
            $this->resetPage('paginadoHerramientas');
            $this->resetPage('paginadoComentarios');
        }
    }

    public function render()
    {
        return view('livewire.materiales.equipo-hidraulico.ficha', [
            'hidraulico' => VtHidraulico::findOrFail($this->hidraulico_id),
            'herramientas' => VtHidraulicoHerr::select('id_hidraulico_herr', 'tipo', 'marca', 'modelo', 'motor', 'operatividad')
                ->where('hidraulico_id', $this->hidraulico_id)
                ->orderBy('tipo', 'asc')
                ->paginate($this->paginadoHerramientas, ['*'], 'herramientas_page'),
            'comentarios' => VtHidraulicoComentario::select('id_hidraulico_comentario', 'comentario', 'hidraulico_id', 'accion', 'nombrecompleto', 'created_at')
                ->where('hidraulico_id', $this->hidraulico_id)
                ->orderBy('created_at', 'desc')
                ->paginate($this->paginadoComentarios, ['*'], 'comentarios_page')
        ]);
    }

    public function mostrarFormAgregarAccion()
    {
        $this->mostrarFormAgregarAccion = true;
    }

    public function openFormAgregarHerramienta()
    {
        $this->dispatch('openFormAgregarHerramienta');
    }
}
