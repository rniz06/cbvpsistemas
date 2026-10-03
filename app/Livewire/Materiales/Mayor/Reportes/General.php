<?php

namespace App\Livewire\Materiales\Mayor\Reportes;

use App\Exports\Excel\Materiales\Mayor\ExcelMayorGeneralExport;
use App\Exports\Pdf\Materiales\Mayor\PdfReporteGeneralExport;
use App\Models\Gral\Compania;
use App\Models\Materiales\Movil\Acronimo;
use App\Models\Materiales\Movil\Combustible;
use App\Models\Materiales\Movil\Eje;
use App\Models\Materiales\Movil\Marca;
use App\Models\Materiales\Movil\Modelo;
use App\Models\Materiales\Movil\Movil;
use App\Models\Materiales\Movil\Transmision;
use App\Models\Materiales\Operatividad;
use App\Models\Vistas\Materiales\VtMayor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class General extends Component
{
    use WithPagination;

    // PROPIEDADES PARA SELECT
    public $companias = [], $acronimos = [], $marcas = [], $modelos = [], $operatividad = [], $anhos = [], $transmisiones = [];
    public $ejes = [], $combustibles = [];

    // PROPIEDADES FILTROS
    public $compania_id, $acronimo_id, $marca_id, $modelo_id, $operatividad_id, $anho_id, $transmision_id;
    public $eje_id, $combustible_id;

    public $paginado = 10;

    public function mount()
    {
        $this->companias     = Compania::select('id_compania', 'compania')->orderBy('orden')->get();
        $this->acronimos     = Acronimo::select('id_movil_tipo', 'tipo')->orderBy('tipo')->get();
        $this->marcas        = Marca::select('id_movil_marca', 'marca')->orderBy('marca')->get();
        $this->modelos       = Modelo::select('id_movil_modelo', 'modelo')->orderBy('modelo')->get();
        $this->operatividad  = Operatividad::select('id_operatividad', 'operatividad')->get();
        $this->anhos         = Movil::distinct()->orderBy('anho', 'desc')->pluck('anho', 'anho')->toArray();
        $this->transmisiones = Transmision::select('id_movil_transmision', 'transmision')->orderBy('transmision')->get();
        $this->ejes          = Eje::select('id_movil_eje', 'eje')->orderBy('eje')->get();
        $this->combustibles  = Combustible::select('id_movil_combustible', 'tipo')->orderBy('tipo')->get();
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, ['compania_id', 'acronimo_id', 'marca_id', 'modelo_id', 'operatividad_id', 'anho_id', 'transmision_id',
         'eje_id', 'combustible_id', 'paginado'
        ])) {
            $this->resetPage();
        }
    }

    public function cargarResultados()
    {
        return VtMayor::select(
            'id_movil',
            DB::raw("CONCAT(tipo, '-', movil) AS movil"),
            'compania',
            'marca',
            'modelo',
            'transmision',
            'eje',
            'combustible',
            'operatividad',
            'anho',
            'chapa',
            'cubiertas_frente',
            'cubiertas_atras',
        )->when($this->compania_id, function (Builder $query, $compania_id) {
            $query->where('compania_id', $compania_id);
        })->when($this->acronimo_id, function (Builder $query, $acronimo_id) {
            $query->where('movil_tipo_id', $acronimo_id);
        })->when($this->marca_id, function (Builder $query, $marca_id) {
            $query->where('marca_id', $marca_id);
        })->when($this->modelo_id, function (Builder $query, $modelo_id) {
            $query->where('modelo_id', $modelo_id);
        })->when($this->operatividad_id, function (Builder $query, $operatividad_id) {
            $query->where('operatividad_id', $operatividad_id);
        })->when($this->anho_id, function (Builder $query, $anho_id) {
            $query->where('anho', $anho_id);
        })->when($this->transmision_id, function (Builder $query, $transmision_id) {
            $query->where('transmision_id', $transmision_id);
        })->when($this->eje_id, function (Builder $query, $eje_id) {
            $query->where('eje_id', $eje_id);
        })->when($this->combustible_id, function (Builder $query, $combustible_id) {
            $query->where('combustible_id', $combustible_id);
        })->paginate($this->paginado);
    }

    public function render()
    {
        //$resultados = $this->cargarResultados();
        return view('livewire.materiales.mayor.reportes.general', [
            'resultados' => $this->cargarResultados()
        ]);
    }

    public function cargarDatosExport()
    {
        return VtMayor::select(
            'id_movil',
            DB::raw("CONCAT(tipo, '-', movil) AS movil"),
            'compania',
            'marca',
            'modelo',
            'transmision',
            'eje',
            'combustible',
            'operatividad',
            'anho',
            'chapa',
            'cubiertas_frente',
            'cubiertas_atras',
        )->when($this->compania_id, function (Builder $query, $compania_id) {
            $query->where('compania_id', $compania_id);
        })->when($this->acronimo_id, function (Builder $query, $acronimo_id) {
            $query->where('movil_tipo_id', $acronimo_id);
        })->when($this->marca_id, function (Builder $query, $marca_id) {
            $query->where('marca_id', $marca_id);
        })->when($this->modelo_id, function (Builder $query, $modelo_id) {
            $query->where('modelo_id', $modelo_id);
        })->when($this->operatividad_id, function (Builder $query, $operatividad_id) {
            $query->where('operatividad_id', $operatividad_id);
        })->when($this->anho_id, function (Builder $query, $anho_id) {
            $query->where('anho', $anho_id);
        })->when($this->transmision_id, function (Builder $query, $transmision_id) {
            $query->where('transmision_id', $transmision_id);
        })->when($this->eje_id, function (Builder $query, $eje_id) {
            $query->where('eje_id', $eje_id);
        })->when($this->combustible_id, function (Builder $query, $combustible_id) {
            $query->where('combustible_id', $combustible_id);
        })->get();    
    }

    public function excel()
    {
        $datos = $this->cargarDatosExport();
        return Excel::download(new ExcelMayorGeneralExport($datos), 'Mayor.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Mayor";
        $datos = $this->cargarDatosExport();
        return (new PdfReporteGeneralExport($datos, $nombre_archivo))->download();
    }
}
