<?php

namespace App\Livewire\Personal;

use App\Models\Vistas\VtResolucionPersonal;
use Livewire\Component;
use Livewire\WithPagination;

class Resolucion extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $personal_id;

    public function mount($personal_id)
    {
        $this->personal_id = $personal_id;
    }

    public function render()
    {
        $resoluciones = VtResolucionPersonal::select('id_resolucion', 'n_resolucion', 'concepto', 'fecha', 'fuente_origen', 'id_personal')
            ->where('id_personal', $this->personal_id)
            ->orderBy('fecha', 'desc')
            ->paginate(2, ['*'], 'resoluciones_page');
        return view('livewire.personal.resolucion', compact('resoluciones'));
    }
}
