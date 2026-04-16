<?php

namespace App\Livewire\Materiales\Menor\Componentes;

use App\Exports\Excel\Materiales\Menor\Componentes\ExcelForestalesComponentesExport;
use App\Exports\Pdf\Materiales\Menor\Componentes\ListaForestalesComponentesPdf;
use App\Models\Materiales\Menor\Componente;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class IndexForestales extends Component
{
    /*
    |------------------------------------------------------
    | RENDERIZA VISTA INDEX DE COMPONENTES DE FORESTALES
    |------------------------------------------------------
    */
    use WithPagination;

    # PROPIEDADES DE BUSQUEDA Y PAGINACION
    public $buscarNombre = '', $paginado;

    # PROPIEDAD PARA PASAR AL MODAL EDIT
    public $componente = null;

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
        return view('livewire.materiales.menor.componentes.index-forestales', [
            'componentes' => $this->queryBase()->paginate($this->paginado, [''], 'componentes-page')
        ]);
    }
    
    public function queryBase()
    {
        return Componente::select('id_menor_componente', 'nombre')
            ->forestales()
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

        $this->redirectRoute('materiales.menor.componentes.index-forestales');
    }

    #[On('abrir-modal-edit')]
    public function abrir_modal_edit($id)
    {
        $this->componente = $id;
    }

    #[On('cerrar-modal-edit')]
    public function cerrar_modal_edit()
    {
        $this->componente = null;
    }

    /*
    |-------------------------------------------------------------
    | FUNCIONES DE EXPORTACION DE DATOS
    |-------------------------------------------------------------
    */

    public function exportar($formatoExportacion)
    {
        $subtitulo = 'Componentes Forestales';
        return match ($formatoExportacion) {
            'excel' => Excel::download(new ExcelForestalesComponentesExport($this->queryBase()->get()), 'Componentes.xlsx'),
            'pdf' => (new ListaForestalesComponentesPdf($this->queryBase()->get(), 'Componentes', $subtitulo))->download(),
        };
    }
}
