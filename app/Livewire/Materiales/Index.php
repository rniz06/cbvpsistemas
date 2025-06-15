<?php

namespace App\Livewire\Materiales;

use App\Models\Vistas\Materiales\VtHidraulicoComentario;
use App\Models\Vistas\Materiales\VtMayorComentario;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.materiales.index', [
            'moviles' => DB::table('MAT_vt_moviles_comentarios')->select('movil', 'tipo', 'comentario', 'accion', 'nombrecompleto', 'created_at')
                ->latest('created_at')->limit(50)->get(),
            'hidraulicos' => DB::table('MAT_vt_hidraulicos_comentarios')->select('compania', 'marca','comentario', 'accion', 'nombrecompleto', 'created_at')
                ->latest('created_at')->limit(50)->get(),
        ]);
    }
}
