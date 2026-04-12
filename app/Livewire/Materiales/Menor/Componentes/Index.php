<?php

namespace App\Livewire\Materiales\Menor\Componentes;

use App\Exports\Excel\Materiales\Menor\Componentes\ExcelMenorComponentesExport;
use App\Exports\Pdf\Materiales\Menor\Componentes\ListaMenorComponentesPdf;
use App\Models\Materiales\Menor\Componente;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    /*
    |------------------------------------------------------
    | RENDERIZA VISTA INDEX DE COMPONENTES DE MATERIAL MENOR
    |------------------------------------------------------
    */
    use WithPagination;

    # PROPIEDADES DE BUSQUEDA Y PAGINACION
    public $buscarNombre = '', $paginado;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount()
    {
        $this->paginado = Auth::user()->paginado_por_defecto ?? 5;
    }

    # LIMPIAR EL BUSCADOR Y LA PAGINACION AL CAMBIAR DE PAGINA
    public function updating($key): void
    {
        if (in_array($key, [
            'buscarNombre',
            'paginado',
        ])) {
            $this->resetPage('componentes-page');
        }
    }

    public function render()
    {
        return view('livewire.materiales.menor.componentes.index', [
            'componentes' => $this->queryBase()->paginate($this->paginado, [''], 'componentes-page')
        ]);
    }

    public function queryBase()
    {
        return Componente::select('id_menor_componente', 'nombre')
            ->menor()
            ->buscarNombre($this->buscarNombre)
            ->orderBy('nombre');
    }

    # ELIMINAR UN REGISTRO
    public function eliminar(int $id): void
    {
        try {
            Componente::findOrFail($id)->delete();
            session()->flash('success', 'COMPONENTE ELIMINADO CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO ELIMINAR - ' . $e->getMessage());
        }

        $this->redirectRoute('materiales.menor.marcas.index');
    }

    /*
    |-------------------------------------------------------------
    | FUNCIONES DE EXPORTACION DE DATOS
    |-------------------------------------------------------------
    */

    public function exportar($formatoExportacion)
    {
        $subtitulo = 'Lista de Componentes Mat. Menor';
        return match ($formatoExportacion) {
            'excel' => Excel::download(new ExcelMenorComponentesExport($this->queryBase()->get()), 'Componentes.xlsx'),
            'pdf' => (new ListaMenorComponentesPdf($this->queryBase()->get(), 'Componentes', $subtitulo))->download(),
        };
    }
}
