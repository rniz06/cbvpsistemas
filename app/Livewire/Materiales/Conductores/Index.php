<?php

namespace App\Livewire\Materiales\Conductores;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Ciudad;
use App\Models\Gral\Compania;
use App\Models\Materiales\Conductor\ClaseLicencia;
use App\Models\Materiales\Conductor\ConductorBombero;
use App\Models\Materiales\Conductor\Estado;
use App\Models\Materiales\Conductor\TipoVehiculo;
use App\Models\UserRoleCompania;
use App\Models\Vistas\Materiales\VtConductor;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    // Usar el trait WithPagination para la paginación
    use WithPagination;

    public $buscador = '';
    public $paginado = 5;
    public $buscarCodigo = null;
    public $buscarNombrecompleto = null;
    public $buscarCompaniaId = null;
    public $buscarEstadoId = null;
    public $buscarClaseLicenciaId = null;

    public $companias = [], $estados = [], $licencias = [];

    public function mount()
    {
        $this->companias = Compania::select('id_compania', 'compania')->orderBy('orden')->get();
        $this->estados   = Estado::select('id_conductor_estado', 'estado')->get();
        $this->licencias = ClaseLicencia::select('idconductor_clase_licencia', 'clase')->get();
    }

    public function updating($key): void
    {
        if (in_array($key, [
            'buscador',
            'paginado',
            'buscarCodigo',
            'buscarNombrecompleto',
            'compania_id',
            'buscarCompaniaId',
            'buscarEstadoId',
            'buscarClaseLicenciaId'
        ])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $usuario = Auth::user();
        $usuarioRoles = null;

        if (!$usuario->hasRole('SuperAdmin')) {
            $usuarioRoles = $usuario->roles()->where('name', 'like', 'materiales_%')->pluck('name')->first();
        }

        switch ($usuarioRoles) {
            case 'materiales_moderador_compania':
                $this->companias = Compania::select('id_compania', 'compania')->where('id_compania', $usuario->compania_id)->get();
                $conductores = VtConductor::select('id_conductor_bombero', 'codigo', 'nombrecompleto', 'compania', 'estado', 'clase_licencia')
                    ->where('compania_id', $usuario->compania_id)
                    ->buscador($this->buscador)
                    ->buscarCodigo($this->buscarCodigo)
                    ->buscarNombrecompleto($this->buscarNombrecompleto)
                    ->buscarCompaniaId($this->buscarCompaniaId)
                    ->buscarEstadoId($this->buscarEstadoId)
                    ->buscarClaseLicenciaId($this->buscarClaseLicenciaId)
                    ->orderBy('nombrecompleto', 'asc')->paginate($this->paginado);
                break;

            case 'materiales_moderador_por_compania':
                $asignacion = UserRoleCompania::whereNotNull('compania_id')->where('usuario_id', $usuario->id_usuario)->first();
                $this->companias = Compania::select('id_compania', 'compania')->where('id_compania', $asignacion?->compania_id)->get();
                $conductores = VtConductor::select('id_conductor_bombero', 'codigo', 'nombrecompleto', 'compania', 'estado', 'clase_licencia')
                    ->where('compania_id', $asignacion?->compania_id)
                    ->buscador($this->buscador)->orderBy('nombrecompleto', 'asc')
                    ->buscarCodigo($this->buscarCodigo)
                    ->buscarNombrecompleto($this->buscarNombrecompleto)
                    ->buscarCompaniaId($this->buscarCompaniaId)
                    ->buscarEstadoId($this->buscarEstadoId)
                    ->buscarClaseLicenciaId($this->buscarClaseLicenciaId)
                    ->paginate($this->paginado);
                break;

            default:
                $conductores = VtConductor::select('id_conductor_bombero', 'codigo', 'nombrecompleto', 'compania', 'estado', 'clase_licencia')
                    ->buscador($this->buscador)
                    ->buscarCodigo($this->buscarCodigo)
                    ->buscarNombrecompleto($this->buscarNombrecompleto)
                    ->buscarCompaniaId($this->buscarCompaniaId)
                    ->buscarEstadoId($this->buscarEstadoId)
                    ->buscarClaseLicenciaId($this->buscarClaseLicenciaId)
                    ->orderBy('nombrecompleto', 'asc')->paginate($this->paginado);
                break;
        }

        return view('livewire.materiales.conductores.index', [
            'conductores' => $conductores,
        ]);
    }

    public function cargarDatosExport()
    {
        return VtConductor::select('nombrecompleto', 'codigo', 'compania', 'resolucion', 'estado', 'ciudad_curso', 'ciudad_licencia', 'tipo_vehiculo', 'clase_licencia')
            ->buscador($this->buscador)
            ->buscarCodigo($this->buscarCodigo)
            ->buscarNombrecompleto($this->buscarNombrecompleto)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->buscarEstadoId($this->buscarEstadoId)
            ->buscarClaseLicenciaId($this->buscarClaseLicenciaId)
            ->get();
    }


    public function excel()
    {
        $datos = $this->cargarDatosExport();
        $encabezados = ['Nombre Completo', 'Codigo', 'Compañia', 'Resolución', 'Estado', 'Ciudad Curso', 'Ciudad Licencia', 'Tipo de Vehiculo', 'Clase de Licencia'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Cbvp Conductores.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Cbvp Conductores";
        $datos = $this->cargarDatosExport();
        $encabezados = ['Nombre Completo', 'Codigo', 'Compañia', 'Resolución', 'Estado', 'Ciudad Curso', 'Ciudad Licencia', 'Tipo de Vehiculo', 'Clase de Licencia'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
