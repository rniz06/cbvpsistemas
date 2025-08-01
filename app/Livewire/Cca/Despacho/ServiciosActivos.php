<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Vistas\Cca\VtExistente;
use Livewire\Component;
use Livewire\WithPagination;

class ServiciosActivos extends Component
{
    use WithPagination;
    public $paginadolistadoActivos = 5;
    public $paginadolistadoSinCompanias = 5;
    public $paginadolistadoSinMoviles = 5;

    // public function verServicio($id)
    // {
    //     return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $id]);
    // }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'paginadolistadoActivos',
            'paginadolistadoSinCompanias',
            'paginadolistadoSinMoviles'
        ])) {
            $this->resetPage('listadoActivos_page');
            $this->resetPage('listadoSinCompanias_page');
            $this->resetPage('listadoSinMoviles_page');
        }
    }

    public function render()
    {
        return view('livewire.cca.despacho.servicios-activos', [
            'listadoActivos' => VtExistente::select('id_servicio_existente', 'compania', 'servicio', 'clasificacion', 'tipo', 'movil', 'informacion_servicio', 'fecha_alfa')
                ->where('estado_id', 3) // Movil Despachado
                ->orderBy('compania')
                ->paginate($this->paginadolistadoActivos, ['*'], 'listadoActivos_page'),

            'listadoSinCompanias' => VtExistente::select('id_servicio_existente', 'servicio', 'clasificacion', 'informacion_servicio')
                ->where('estado_id', 1) // Inicializado - Denunciado en alfa
                ->paginate($this->paginadolistadoSinCompanias, ['*'], 'listadoSinCompanias_page'),

            'listadoSinMoviles' => VtExistente::select('id_servicio_existente', 'compania', 'servicio', 'clasificacion', 'informacion_servicio')
                ->where('estado_id', 2) // Compañia Despachada
                ->orderBy('compania')
                ->paginate($this->paginadolistadoSinMoviles, ['*'], 'listadoSinMoviles_page')
        ]);
    }
}
