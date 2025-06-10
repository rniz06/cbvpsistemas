<?php

namespace App\Livewire\Materiales\Mayor;

use App\Models\Vistas\Materiales\VtMayor;
use App\Models\Vistas\VtCompania;
use Livewire\Component;
use Livewire\WithPagination;

class VerCompania extends Component
{
    use WithPagination;

    // Recibe le ID de la compania desde la ruta
    public $compania_id;

    // Variables para la paginación, busqueda y filtros
    public $paginadoMoviles = 10;


    public function render()
    {
        return view('livewire.materiales.mayor.ver-compania',[
            'compania' => VtCompania::select('compania', 'ciudad', 'departamento')->findOrFail($this->compania_id),
            'moviles' => VtMayor::select('id_movil', 'movil', 'tipo', 'operatividad', 'marca', 'compania_id', 'operativo')
                ->where('operativo', 1)
                ->where('compania_id', $this->compania_id)
                ->orderBy('operatividad', 'desc')
                ->orderBy('tipo')
                ->orderBy('movil')
                ->paginate($this->paginadoMoviles, ['*'], 'moviles_page')
        ]);
    }
}
