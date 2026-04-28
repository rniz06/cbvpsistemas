<?php

namespace App\Livewire\Materiales\Menor\Categorias;

use App\Models\Materiales\Menor\Categoria;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    /*
    |------------------------------------------------------
    | Componente central que renderiza tabla de Categorias
    |------------------------------------------------------
    */
    use WithPagination;

    # PROPIEDADES DE BUSQUEDA Y PAGINACION
    public $buscador = '', $paginado;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount()
    {
        $this->paginado      = Auth::user()->paginado_por_defecto ?? 5;
    }

    # LIMPIAR EL BUSCADOR Y LA PAGINACION AL CAMBIAR DE PAGINA
    public function updating($key): void
    {
        if (in_array($key, [
            'buscador',
            'paginado',
        ])) {
            $this->resetPage('categorias-page');
        }
    }

    public function render()
    {
        return view('livewire.materiales.menor.categorias.index', [
            'categorias' => $this->queryBase()->paginate($this->paginado, [''], 'categorias-page')
        ]);
    }

    public function queryBase()
    {
        return Categoria::select('id_menor_categoria', 'nombre')
            ->buscador($this->buscador)
            ->orderBy('nombre');
    }
}
