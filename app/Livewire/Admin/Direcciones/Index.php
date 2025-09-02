<?php

namespace App\Livewire\Admin\Direcciones;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Vistas\Gral\GralVtDireccion;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    public $buscador = '';
    public $buscarDireccion = '';
    public $buscarCompania = '';
    public $paginado = 5;

    protected $listeners = ['direccionActualizado' => '$refresh'];

    public function seleccionado($id)
    {
        $this->dispatch('direccionSeleccionado', $id);
    }

    public function updating($key): void
    {
        if ($key === 'buscador' || $key === 'buscarDireccion' || $key === 'buscarCompania' || $key === 'paginado') {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.admin.direcciones.index', [
            'direcciones' => GralVtDireccion::select('id_direccion', 'direccion', 'compania')
                ->buscador($this->buscador)
                ->buscarDireccion($this->buscarDireccion)
                ->buscarCompania($this->buscarCompania)
                ->orderBy('direccion')
                ->paginate($this->paginado),
        ]);
    }

    public function cargarDatosParaExpotar()
    {
        return GralVtDireccion::select('direccion', 'compania')
            ->buscador($this->buscador)
            ->buscarDireccion($this->buscarDireccion)
            ->buscarCompania($this->buscarCompania)
            ->orderBy('direccion')
            ->get();
    }

    public function excel()
    {
        $datos = $this->cargarDatosParaExpotar();
        $encabezados = ['Dirección', 'Depende De'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Listado de Direcciones CBVP.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Listado de Direcciones CBVP";
        $datos = $this->cargarDatosParaExpotar();
        $encabezados = ['Dirección', 'Depende De'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
