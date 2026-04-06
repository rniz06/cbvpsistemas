<?php

namespace App\Livewire\Materiales\Menor\Marcas;

use App\Models\Materiales\Menor\Marca;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    /*
    |------------------------------------------------------
    | RENDERIZA VISTA INDEX DE MARCAS DE MATERIAL MENOR
    |------------------------------------------------------
    */
    use WithPagination;

    # PROPIEDADES DE BUSQUEDA Y PAGINACION
    public $buscarNombre = '', $paginado;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount()
    {
        $this->paginado          = Auth::user()->paginado_por_defecto ?? 5;
    }

    # LIMPIAR EL BUSCADOR Y LA PAGINACION AL CAMBIAR DE PAGINA
    public function updating($key): void
    {
        if (in_array($key, [
            'buscarNombre',
            'paginado',
        ])) {
            $this->resetPage('marcas-page');
        }
    }

    public function render()
    {
        return view('livewire.materiales.menor.marcas.index', [
            'marcas' => Marca::select('id_menor_marca', 'nombre')
                ->buscarNombre($this->buscarNombre)
                ->paginate($this->paginado, [''], 'marcas-page')
        ]);
    }

    # ELIMINAR UN REGISTRO
    public function eliminar(int $id): void
    {
        try {
            Marca::findOrFail($id)->delete();
            session()->flash('success', 'MARCA ELIMINADA CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO ELIMINAR LA MARCA - ' . $e->getMessage());
        }

        $this->redirectRoute('materiales.menor.marcas.index');
    }
}
