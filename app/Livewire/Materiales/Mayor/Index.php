<?php

namespace App\Livewire\Materiales\Mayor;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Ciudad;
use App\Models\Compania;
use App\Models\Departamento;
use App\Models\Vistas\Materiales\VtMayor;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    // Variables para la paginación, busqueda y filtros
    public $buscadorOperativo = '';
    public $buscadorInoperativo = '';
    public $departamento_id = '';
    public $ciudad_id = '';
    public $paginadoOperativo = 5;
    public $paginadoInoperativo = 5;
    public $paginadoResumen = 5;
    // #[Url]
    public $compania_id = '';

    // Funcion que deriva a la vista ver compania

    public function verCompania()
    {
        return redirect()->route('materiales.mayor.ver-compania', $this->compania_id);
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscadorOperativo',
            'buscadorInoperativo',
            'departamento_id',
            'ciudad_id',
            'compania_id',
            'paginadoOperativo',
            'paginadoInoperativo',
            'paginadoResumen'
        ])) {
            $this->resetPage('operativos_page');
            $this->resetPage('inoperativos_page');
            $this->resetPage('resumen_page');
        }
    }


    public function render()
    {
        return view('livewire.materiales.mayor.index', [
            'operativos' => VtMayor::select('id_movil', 'movil', 'tipo', 'compania', 'compania_id', 'ciudad_id', 'departamento_id')
                ->where('operativo', 1) // Filtrar por operativos
                ->where('operatividad_id', 1) // operativos
                ->buscarDepartamentoId($this->departamento_id)
                ->buscarCiudadId($this->ciudad_id)
                ->buscarCompaniaId($this->compania_id)
                ->buscador($this->buscadorOperativo)
                ->orderBy('tipo')
                ->orderBy('movil')
                ->paginate($this->paginadoOperativo, ['*'], 'operativos_page'),
            'inoperativos' => VtMayor::select('id_movil', 'movil', 'tipo', 'compania', 'compania_id', 'ciudad_id', 'departamento_id')
                ->where('operativo', 1) // Filtrar por operativos
                ->where('operatividad_id', 0) // pero fuera de servicio momentaneamente
                ->buscarDepartamentoId($this->departamento_id)
                ->buscarCiudadId($this->ciudad_id)
                ->buscarCompaniaId($this->compania_id)
                ->buscador($this->buscadorInoperativo)
                ->orderBy('tipo')
                ->orderBy('movil')
                ->paginate($this->paginadoInoperativo, ['*'], 'inoperativos_page'),
            'resumen' => VtMayor::selectRaw('tipo,
              SUM(CASE WHEN operatividad_id = 1 THEN 1 ELSE 0 END) as operativos,
              SUM(CASE WHEN operatividad_id = 0 THEN 1 ELSE 0 END) as inoperativos')
                ->where('operativo', 1) // Filtrar por operativos (igual que en tus otras consultas)
                ->buscarDepartamentoId($this->departamento_id)
                ->buscarCiudadId($this->ciudad_id)
                ->buscarCompaniaId($this->compania_id)
                ->groupBy('tipo')
                ->orderBy('tipo')
                ->paginate($this->paginadoResumen, ['*'], 'resumen_page'),
            'departamentos' => Departamento::select('iddepartamentos', 'departamento')->orderBy('departamento')->get(),

            'ciudades' => $this->departamento_id
                ? Ciudad::select('idciudades', 'ciudad')
                ->where('departamento_id', $this->departamento_id)
                ->orderBy('ciudad')
                ->get()
                : Ciudad::select('idciudades', 'ciudad')
                ->orderBy('ciudad')
                ->get(),

            'companias' => $this->ciudad_id
                ? Compania::select('idcompanias', 'compania')
                ->where('ciudad_id', $this->ciudad_id)
                ->orderBy('orden')
                ->get()
                : Compania::select('idcompanias', 'compania')
                ->orderBy('orden')
                ->get(),
        ]);
    }

    public function updatedDepartamentoId($value)
    {
        $this->ciudad_id = '';
        $this->compania_id = ''; // Opcional: también limpia la compañía
    }

    public function updatedCiudadId($value)
    {
        $this->compania_id = '';
    }

    public function excelOperativo()
    {
        $datos = VtMayor::select('tipo', 'movil', 'compania')->where('operativo', 1)->where('operatividad_id', 1)
            ->buscarDepartamentoId($this->departamento_id)
            ->buscarCiudadId($this->ciudad_id)
            ->buscarCompaniaId($this->compania_id)
            ->orderBy('tipo')
            ->orderBy('movil')->get()->map(function ($item) {
                return [
                    'movil' => $item->tipo . '-' . $item->movil,
                    'compañia' => $item->compania,
                ];
            });
        $encabezados = ['Movil', 'Compañia'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Material Mayor Operativo.xlsx');
    }

    public function pdfOperativo()
    {
        $nombre_archivo = "Material Mayor Operativo";
        $datos = VtMayor::select('tipo', 'movil', 'compania')->where('operativo', 1)->where('operatividad_id', 1)
            ->buscarDepartamentoId($this->departamento_id)
            ->buscarCiudadId($this->ciudad_id)
            ->buscarCompaniaId($this->compania_id)
            ->orderBy('tipo')
            ->orderBy('movil')
            ->get()
            ->map(function ($item) {
                return collect([
                    'movil' => $item->tipo . '-' . $item->movil,
                    'compañia' => $item->compania,
                ]);
            });
        $encabezados = ['Movil', 'Compañia'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }

    public function excelInoperativo()
    {
        $datos = VtMayor::select('tipo', 'movil', 'compania')->where('operativo', 1)->where('operatividad_id', 0)
            ->buscarDepartamentoId($this->departamento_id)
            ->buscarCiudadId($this->ciudad_id)
            ->buscarCompaniaId($this->compania_id)
            ->orderBy('tipo')
            ->orderBy('movil')->get()->map(function ($item) {
                return [
                    'movil' => $item->tipo . '-' . $item->movil,
                    'compañia' => $item->compania,
                ];
            });
        $encabezados = ['Movil', 'Compañia'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Material Mayor Inoperativo.xlsx');
    }

    public function pdfInoperativo()
    {
        $nombre_archivo = "Material Mayor Inoperativo";
        $datos = VtMayor::select('tipo', 'movil', 'compania')->where('operativo', 1)->where('operatividad_id', 0)
            ->buscarDepartamentoId($this->departamento_id)
            ->buscarCiudadId($this->ciudad_id)
            ->buscarCompaniaId($this->compania_id)
            ->orderBy('tipo')
            ->orderBy('movil')
            ->get()
            ->map(function ($item) {
                return collect([
                    'movil' => $item->tipo . '-' . $item->movil,
                    'compañia' => $item->compania,
                ]);
            });
        $encabezados = ['Movil', 'Compañia'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }

    public function excelResumen()
    {
        $datos = VtMayor::selectRaw('tipo,
              SUM(CASE WHEN operatividad_id = 1 THEN 1 ELSE 0 END) as operativos,
              SUM(CASE WHEN operatividad_id = 0 THEN 1 ELSE 0 END) as inoperativos')
            ->where('operativo', 1) // Filtrar por operativos (igual que en tus otras consultas)
            ->buscarDepartamentoId($this->departamento_id)
            ->buscarCiudadId($this->ciudad_id)
            ->buscarCompaniaId($this->compania_id)
            ->groupBy('tipo')
            ->orderBy('tipo')
            ->get();
        $encabezados = ['Movil', 'Operativos', 'Inoperativos'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Resumen Material Mayor.xlsx');
    }

    public function pdfResumen()
    {
        $nombre_archivo = "Resumen Material Mayor";
        $datos = VtMayor::selectRaw('tipo,
              SUM(CASE WHEN operatividad_id = 1 THEN 1 ELSE 0 END) as operativos,
              SUM(CASE WHEN operatividad_id = 0 THEN 1 ELSE 0 END) as inoperativos')
            ->where('operativo', 1) // Filtrar por operativos (igual que en tus otras consultas)
            ->buscarDepartamentoId($this->departamento_id)
            ->buscarCiudadId($this->ciudad_id)
            ->buscarCompaniaId($this->compania_id)
            ->groupBy('tipo')
            ->orderBy('tipo')
            ->get();
        $encabezados = ['Movil', 'Operativos', 'Inoperativos'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
