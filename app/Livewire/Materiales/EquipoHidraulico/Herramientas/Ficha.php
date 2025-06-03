<?php

namespace App\Livewire\Materiales\EquipoHidraulico\Herramientas;

use App\Models\Vistas\Materiales\VtHidraulicoHerr;
use App\Models\Vistas\Materiales\VtHidraulicoHerrComentario;
use Livewire\Component;

class Ficha extends Component
{
    public $hidraulico;
    public $herramienta;
    public $paginado = 5;

    public function render()
    {
        return view('livewire.materiales.equipo-hidraulico.herramientas.ficha', [
            'comentarios' => VtHidraulicoHerrComentario::select('comentario', 'herramienta_id', 'accion', 'nombrecompleto', 'created_at')
                ->where('herramienta_id', $this->herramienta->id_hidraulico_herr)
                ->orderBy('created_at', 'desc')
                ->paginate($this->paginado, ['*'], 'comentarios_page'),
        ]);
    }

    public function openFormAgregarAccion()
    {
        $this->dispatch('openFormAgregarAccion');
    }
}
