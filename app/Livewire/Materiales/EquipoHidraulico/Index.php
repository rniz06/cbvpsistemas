<?php

namespace App\Livewire\Materiales\EquipoHidraulico;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Ciudad;
use App\Models\Compania;
use App\Models\Departamento;
use App\Models\Vistas\Materiales\VtHidraulico;
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
    public $compania_id = '';
    public $paginadoOperativo = 5;
    public $paginadoInoperativo = 5;

    // Funcion que deriva a la vista ver compania
    public function verCompania()
    {
        return redirect()->route('materiales.hidraulicos.ver-compania', $this->compania_id);
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
        ])) {
            $this->resetPage('operativos_page');
            $this->resetPage('inoperativos_page');
        }
    }


    public function render()
    {
        return view('livewire.materiales.equipo-hidraulico.index', [
            'operativos' => VtHidraulico::select('id_hidraulico', 'marca', 'modelo', 'compania', 'compania_id', 'ciudad_id', 'departamento_id')
                ->where('operativo', 1) // Filtrar por operativos
                ->where('operatividad_id', 1) // operativos
                ->buscarDepartamentoId($this->departamento_id)
                ->buscarCiudadId($this->ciudad_id)
                ->buscarCompaniaId($this->compania_id)
                ->buscador($this->buscadorOperativo)
                ->orderBy('marca')
                ->orderBy('modelo')
                ->paginate($this->paginadoOperativo, ['*'], 'operativos_page'),
            'inoperativos' => VtHidraulico::select('id_hidraulico', 'marca', 'modelo', 'compania', 'compania_id', 'ciudad_id', 'departamento_id')
                ->where('operativo', 1) // Filtrar por operativos
                ->where('operatividad_id', 0) // pero fuera de servicio momentaneamente
                ->buscarDepartamentoId($this->departamento_id)
                ->buscarCiudadId($this->ciudad_id)
                ->buscarCompaniaId($this->compania_id)
                ->buscador($this->buscadorInoperativo)
                ->orderBy('marca')
                ->orderBy('modelo')
                ->paginate($this->paginadoInoperativo, ['*'], 'inoperativos_page'),
            'departamentos' => Departamento::select('iddepartamentos', 'departamento')->orderBy('departamento')->get(),
            'ciudades' => Ciudad::select('idciudades', 'ciudad')->orderBy('ciudad')->get(),
            'companias' => Compania::select('idcompanias', 'compania')->orderBy('orden')->get(),
        ]);
    }

    public function excelOperativo()
    {
        $datos = VtHidraulico::select('marca', 'modelo', 'compania')->where('operativo', 1)->where('operatividad_id', 1)
            ->buscarDepartamentoId($this->departamento_id)
            ->buscarCiudadId($this->ciudad_id)
            ->buscarCompaniaId($this->compania_id)
            ->orderBy('marca')
            ->orderBy('modelo')->get();
        $encabezados = ['Marca', 'Modelo', 'Compañia'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Equipo Hidraulico Operativo.xlsx');
    }

    public function pdfOperativo()
    {
        $nombre_archivo = "Equipo Hidraulico Operativo";
        $datos = VtHidraulico::select('marca', 'modelo', 'compania')->where('operativo', 1)->where('operatividad_id', 1)
            ->buscarDepartamentoId($this->departamento_id)
            ->buscarCiudadId($this->ciudad_id)
            ->buscarCompaniaId($this->compania_id)
            ->orderBy('marca')
            ->orderBy('modelo')
            ->get();
        $encabezados = ['Marca', 'Modelo', 'Compañia'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }

    public function excelInoperativo()
    {
        $datos = VtHidraulico::select('marca', 'modelo', 'compania')->where('operativo', 1)->where('operatividad_id', 0)
            ->buscarDepartamentoId($this->departamento_id)
            ->buscarCiudadId($this->ciudad_id)
            ->buscarCompaniaId($this->compania_id)
            ->orderBy('marca')
            ->orderBy('modelo')->get();
        $encabezados = ['Marca', 'Modelo', 'Compañia'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Equipo Hidraulico Inoperativo.xlsx');
    }

    public function pdfInoperativo()
    {
        $nombre_archivo = "Equipo Hidraulico Inoperativo";
        $datos = VtHidraulico::select('marca', 'modelo', 'compania')->where('operativo', 1)->where('operatividad_id', 0)
            ->buscarDepartamentoId($this->departamento_id)
            ->buscarCiudadId($this->ciudad_id)
            ->buscarCompaniaId($this->compania_id)
            ->orderBy('marca')
            ->orderBy('modelo')
            ->get();
        $encabezados = ['Marca', 'Modelo', 'Compañia'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
