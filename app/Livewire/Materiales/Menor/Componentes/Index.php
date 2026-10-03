<?php

namespace App\Livewire\Materiales\Menor\Componentes;

use App\Actions\Materiales\Menor\EliminarComponenteEnTodasLasCompanias;
use App\Exports\Excel\Materiales\Menor\Componentes\ExcelMenorComponentesExport;
use App\Exports\Pdf\Materiales\Menor\Componentes\ListaMenorComponentesPdf;
use App\Models\Materiales\Menor\Categoria;
use App\Models\Materiales\Menor\Componente;
use App\Models\Materiales\Menor\Tipo;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    /*
    |------------------------------------------------------
    | RENDERIZA VISTA INDEX DE COMPONENTES DE MATERIAL MENOR
    |------------------------------------------------------
    */
    use WithPagination;

    # PROPIEDADES DE BUSQUEDA Y PAGINACION
    public $buscarNombre = '', $buscarTipoId = '', $buscarCategoriaId = '', $paginado;

    # PROPIEDADES PARA LOS SELECTS
    public $tipos = [], $categorias = [];

    # PROPIEDAD PARA PASAR AL MODAL EDIT
    public $componente = null;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount()
    {
        $this->paginado   = Auth::user()->paginado_por_defecto ?? 5;
        $this->tipos      = Tipo::orderBy('tipo')->get(['id_menor_tipo', 'tipo']);
        $this->categorias = Categoria::orderBy('nombre')->get(['id_menor_categoria', 'nombre']);
    }

    # LIMPIAR EL BUSCADOR Y LA PAGINACION AL CAMBIAR DE PAGINA
    public function updating($key): void
    {
        if (in_array($key, [
            'buscarNombre',
            'buscarTipoId',
            'buscarCategoriaId',
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
        return Componente::select('id_menor_componente', 'nombre', 'tipo_id', 'categoria_id')
            ->with([
                'tipo:id_menor_tipo,tipo',
                'categoria:id_menor_categoria,nombre',
            ])
            ->buscarNombre($this->buscarNombre)
            ->buscarTipoId($this->buscarTipoId)
            ->buscarCategoriaId($this->buscarCategoriaId)
            ->orderBy('nombre');
    }

    # ELIMINAR UN REGISTRO
    public function eliminar(int $id, EliminarComponenteEnTodasLasCompanias $action): void
    {
        try {
            $action->handle($id);
            session()->flash('success', 'COMPONENTE ELIMINADO CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO ELIMINAR - ' . $e->getMessage());
        }

        $this->redirectRoute('materiales.menor.componentes.index');
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
        $subtitulo = 'Lista de Componentes';
        return match ($formatoExportacion) {
            'excel' => Excel::download(new ExcelMenorComponentesExport($this->queryBase()->get()), 'Componentes.xlsx'),
            'pdf' => (new ListaMenorComponentesPdf($this->queryBase()->get(), 'Componentes', $subtitulo))->download(),
        };
    }
}
