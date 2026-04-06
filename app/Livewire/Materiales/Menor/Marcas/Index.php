<?php

namespace App\Livewire\Materiales\Menor\Marcas;

use App\Exports\Excel\Materiales\Menor\Marcas\ExcelMenorMarcasExport;
use App\Exports\Pdf\Materiales\Menor\Marcas\ListaMenorMarcasPdf;
use App\Models\Materiales\Menor\Marca;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

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

    private function cargarDatosParaExportar() : Collection
    {
        return Marca::select('id_menor_marca', 'nombre')
            ->buscarNombre($this->buscarNombre)
            ->orderBy('nombre')
            ->get();
    }

    public function excel()
    {
        $datos = $this->cargarDatosParaExportar();

        return Excel::download(new ExcelMenorMarcasExport($datos), 'Marcas.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Marcas";
        $datos = $this->cargarDatosParaExportar();

        return (new ListaMenorMarcasPdf($datos, $nombre_archivo))->download();
    }
}
