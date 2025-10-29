<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Detalle;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Personal extends Component
{
    use WithPagination;

    public $asistencia;

    // PROPIEDADES DE FILTRADO
    public $buscarNombreCompleto, $buscarCodigo, $paginado = 5;

    public function mount($asistencia)
    {
        $this->asistencia = Asistencia::findOrfail($asistencia);
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscarNombreCompleto',
            'buscarCodigo',
            'paginado'
        ])) {
            $this->resetPage('personales_page');
        }
    }

    public function render()
    {
        return view('livewire.personal.asistencias.personal', [
            'personales' => Detalle::select('id_asistencia_detalle', 'personal_id','asistencia_id', 'practica', 'guardia', 'citacion')
                ->with('personal:idpersonal,nombrecompleto,codigo')
                ->where('asistencia_id', $this->asistencia->id_asistencia)
                ->paginate($this->paginado, ['*'], 'personales_page')
        ]);
    }
}
