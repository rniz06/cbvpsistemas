<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Vistas\Cca\VtExistente;
use App\Models\Vistas\Cca\VtExistenteApoyo;
use Livewire\Component;
use Livewire\WithPagination;

class ServiciosActivos911 extends Component
{
    use WithPagination;
    public $paginadolistadoActivos = 15;
    public $paginadolistadoSinCompanias = 10;
    public $paginadolistadoSinMoviles = 10;
    public $paginadoApoyosActivos = 10;

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'paginadolistadoActivos',
            'paginadolistadoSinCompanias',
            'paginadolistadoSinMoviles',
            'paginadoApoyosActivos'
        ])) {
            $this->resetPage('listadoActivos_page');
            $this->resetPage('listadoSinCompanias_page');
            $this->resetPage('listadoSinMoviles_page');
            $this->resetPage('apoyos_activos_page');
        }
    }

    public function render()
    {
        return view('livewire.cca.despacho.servicios-activos911', [
            'listadoActivos' => VtExistente::select('id_servicio_existente', 'compania', 'servicio', 'clasificacion', 'tipo', 'movil', 'informacion_servicio', 'fecha_alfa')
                ->where('estado_id', 3) // Movil Despachado
                ->where('despacho_policia', true) # SOLO DESPACHO DE 911
                ->orderBy('compania')
                ->paginate($this->paginadolistadoActivos, ['*'], 'listadoActivos_page'),

            'listadoSinCompanias' => VtExistente::select('id_servicio_existente', 'servicio', 'clasificacion', 'informacion_servicio')
                ->where('estado_id', 1) // Inicializado - Denunciado en alfa
                ->where('despacho_policia', true) # SOLO DESPACHO DE 911
                ->paginate($this->paginadolistadoSinCompanias, ['*'], 'listadoSinCompanias_page'),

            'listadoSinMoviles' => VtExistente::select('id_servicio_existente', 'compania', 'servicio', 'clasificacion', 'informacion_servicio')
                ->where('estado_id', 2) // Compañia Despachada
                ->where('despacho_policia', true) # SOLO DESPACHO DE 911
                ->orderBy('compania')
                ->paginate($this->paginadolistadoSinMoviles, ['*'], 'listadoSinMoviles_page'),
            'apoyosActivos' => VtExistenteApoyo::select('idservicio_existente_apoyo', 'servicio_existente_id', 'compania', 'servicio', 'clasificacion', 'tipo', 'movil', 'fecha_cia')
                ->whereNull('fecha_base')
                ->orderBy('compania')
                ->paginate($this->paginadoApoyosActivos, ['*'], 'apoyos_activos_page'),
        ]);
    }
}
