<?php

namespace App\Livewire\Personal\Comisionamientos;

use App\Models\Admin\CompaniaGral;
use App\Models\Vistas\Personal\VtComisionamiento;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Propiedad para los filtros
    public $companias = [];

    // Variables para la paginación y busqueda
    public $buscarNombreCompleto = '';
    public $buscarCodigo = '';
    public $buscarCompaniaId = '';
    public $buscarFechaInicio = '';
    public $buscarFechaFin = '';
    public $buscarCodigoComisionamiento = '';
    public $buscarCulminado = '';
    public $paginado = 5;

    public function mount()
    {
        $this->companias = CompaniaGral::select('id_compania', 'compania')->orderBy('orden')->get();
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscarNombreCompleto',
            'buscarCodigo',
            'buscarCompaniaId',
            'buscarFechaInicio',
            'buscarFechaFin',
            'buscarCodigoComisionamiento',
            'buscarCulminado',
            'paginado',
        ])) {
            $this->resetPage('comisionados_page');
        }
    }

    public function render()
    {
        return view('livewire.personal.comisionamientos.index', [
            'comisionamientos' => VtComisionamiento::select(
                'id_comisionamiento',
                'nombrecompleto',
                'codigo',
                'compania',
                'resolucion_id',
                'fecha_inicio',
                'fecha_fin',
                'codigo_comisionamiento',
                'culminado'
            )
            ->buscarNombreCompleto($this->buscarNombreCompleto)
                ->buscarCodigo($this->buscarCodigo)
                ->buscarCompaniaId($this->buscarCompaniaId)
                ->buscarFechaInicio($this->buscarFechaInicio)
                ->buscarFechaFin($this->buscarFechaFin)
                ->buscarFechaFin($this->buscarFechaFin)
                ->buscarCodigoComisionamiento($this->buscarCodigoComisionamiento)
                ->buscarCulminado($this->buscarCulminado)
                ->paginate($this->paginado, ['*'], 'comisionados_page')
        ]);
    }
}
