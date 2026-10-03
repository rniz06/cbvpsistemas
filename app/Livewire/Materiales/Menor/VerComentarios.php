<?php

namespace App\Livewire\Materiales\Menor;

use App\Models\Materiales\Menor\Item;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class VerComentarios extends Component
{
    /*
    |--------------------------------------------------------
    | COMPONENTE RENDERIZA COMENTARIOS DEL ITEM
    |--------------------------------------------------------
    */
    use WithPagination, WithoutUrlPagination;

    public $item, $paginado;

    public function mount(Item $item)
    {
        $this->item = $item;
        $this->paginado = Auth::user()->paginado_por_defecto ?? 10;
    }

    # LIMPIAR EL BUSCADOR Y LA PAGINACION AL CAMBIAR DE PAGINA
    public function updating($key): void
    {
        if (in_array($key, [
            'paginado',
        ])) {
            $this->resetPage('comentarios-page');
        }
    }

    public function render()
    {
        return view('livewire.materiales.menor.ver-comentarios', [
            'comentarios' => $this->item->comentarios()
            ->select('idmenor_item_comentario', 'comentario', 'accion_id', 'creadoPor', 'created_at')
            ->with([
                'accion:id_accion,accion',
                'creadopor:id_usuario,nombrecompleto',
            ])
            ->orderByDesc('created_at')
            ->paginate($this->paginado, [''], 'comentarios-page'),
        ]);
    }

    public function cerrarModal()
    {
        $this->resetPage('comentarios-page');
    }
}
