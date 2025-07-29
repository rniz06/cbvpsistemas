<?php

namespace App\Livewire\Perfil;

use App\Models\Vistas\Personal\VtComisionamiento;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MisComisionamientos extends Component
{
    use WithPagination;

    public function render()
    {
        $usuario = Auth::user();
        return view('livewire.perfil.mis-comisionamientos', [
            'comisionamientos' => VtComisionamiento::select(
                'compania',
                'n_resolucion',
                'fecha_inicio',
                'fecha_fin',
                'codigo_comisionamiento',
                'culminado',
                'resolucion_id',
            )->where('personal_id', $usuario->personal_id)
                ->paginate(5, ['*'], 'mis_comisionamientos_page')
        ]);
    }
}
