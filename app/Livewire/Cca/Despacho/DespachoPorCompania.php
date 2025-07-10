<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Admin\CiudadGral;
use App\Models\Admin\DepartamentoGral;
use App\Models\Admin\RegionGral;
use App\Models\Vistas\GralVtCompania;
use Livewire\Component;
use Livewire\WithPagination;

class DespachoPorCompania extends Component
{
    use WithPagination;

    // Propiedad para los filtros
    public $ciudades, $regiones, $departamentos;

    // Variables para la paginación y busqueda
    public $buscador = '';
    public $buscarCompania = '';
    public $buscarDepartamentoId = '';
    public $buscarCiudadId = '';
    public $buscarRegionId = '';
    public $paginado = 5;

    public function mount()
    {
        $this->regiones = RegionGral::select('id_region', 'region')->get();
        $this->departamentos = DepartamentoGral::select('id_departamento', 'departamento')->get();
        $this->ciudades = CiudadGral::select('id_ciudad', 'ciudad', 'departamento_id')
            ->when($this->buscarDepartamentoId, function ($query) {
                return $query->where('departamento_id', $this->buscarDepartamentoId);
            })
            ->orderBy('ciudad')
            ->get();
    }

    // Actualizar la propiedad buscarDepartamentoId
    public function updatedBuscarDepartamentoId($value)
    {
        $this->ciudades = CiudadGral::select('id_ciudad', 'ciudad', 'departamento_id')
            ->when($value, function ($query) use ($value) {
                return $query->where('departamento_id', $value);
            })
            ->orderBy('ciudad')
            ->get();

        // Resetear la selección de ciudad cuando cambia el departamento
        $this->buscarCiudadId = '';
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscador',
            'paginado',
            'buscarDepartamentoId',
            'buscarCiudadId',
            'buscarRegionId',
        ])) {
            $this->resetPage('companias_page');
        }
    }

    public function render()
    {
        return view('livewire.cca.despacho.despacho-por-compania', [
            'companias' => GralVtCompania::select('id_compania', 'compania', 'departamento', 'ciudad', 'region')
                ->buscador($this->buscador)
                ->buscarCompania($this->buscarCompania)
                ->buscarDepartamentoId($this->buscarDepartamentoId)
                ->buscarCiudadId($this->buscarCiudadId)
                ->buscarRegionId($this->buscarRegionId)
                ->orderBy('orden')
                ->paginate($this->paginado, ['*'], 'companias_page')
        ]);
    }
}
