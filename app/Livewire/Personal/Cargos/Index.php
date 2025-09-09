<?php

namespace App\Livewire\Personal\Cargos;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Personal\Rango;
use App\Models\Vistas\Personal\VtCargo;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    public $buscador = '';
    public $buscarCargo = '';
    public $buscarRangoId = '';
    public $paginado = 5;

    // Datos para los filtros
    public $rangos = [];

    protected $listeners = ['cargoActualizado' => '$refresh'];

    public function mount()
    {
        $this->rangos = Rango::select('id_rango', 'rango')->orderBy('rango')->get();
    }

    public function seleccionado($id)
    {
        $this->dispatch('cargoSeleccionado', $id);
    }

    public function updating($key): void
    {
        if ($key === 'buscador' || $key === 'buscarCargo' || $key === 'buscarRangoId' || $key === 'paginado') {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.personal.cargos.index', [
            'cargos' => VtCargo::select('id_cargo', 'cargo', 'rango')
                ->buscador($this->buscador)
                ->buscarCargo($this->buscarCargo)
                ->buscarRangoId($this->buscarRangoId)
                ->orderBy('cargo')
                ->paginate($this->paginado),
        ]);
    }

    public function cargarDatosParaExpotar()
    {
        return VtCargo::select('cargo', 'rango')
            ->buscador($this->buscador)
            ->buscarCargo($this->buscarCargo)
            ->buscarRangoId($this->buscarRangoId)
            ->orderBy('cargo')
            ->get();
    }

    public function excel()
    {
        $datos = $this->cargarDatosParaExpotar();
        $encabezados = ['Cargo', 'Rango'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Listado de Cargos CBVP.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Listado de Cargos CBVP";
        $datos = $this->cargarDatosParaExpotar();
        $encabezados = ['Cargo', 'Rango'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
