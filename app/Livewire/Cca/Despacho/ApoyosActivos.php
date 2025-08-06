<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Vistas\Cca\VtExistenteApoyo;
use Livewire\Component;
use Livewire\WithPagination;

class ApoyosActivos extends Component
{
    use WithPagination;
    public $paginado = 5;

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'paginado',
        ])) {
            $this->resetPage('apoyos_activos_page');
        }
    }

    public function render()
    {
        return view('livewire.cca.despacho.apoyos-activos', [
            'apoyosActivos' => VtExistenteApoyo::select('idservicio_existente_apoyo', 'servicio_existente_id', 'compania', 'servicio', 'clasificacion', 'tipo', 'movil', 'fecha_cia')
                ->whereNull('fecha_base')
                ->orderBy('compania')
                ->paginate($this->paginado, ['*'], 'apoyos_activos_page'),
        ]);
    }
}
