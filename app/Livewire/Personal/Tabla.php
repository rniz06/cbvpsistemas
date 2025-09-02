<?php

namespace App\Livewire\Personal;

use App\Exports\ExcelGenericoExport;
use App\Models\Compania;
use App\Models\Personal\Categoria;
use App\Models\Personal\Estado;
use App\Models\Personal\EstadoActualizar;
use App\Models\Personal\GrupoSanguineo;
use App\Models\Personal\Pais;
use App\Models\Personal\Sexo;
use App\Models\UserRoleCompania;
use App\Models\Vistas\VtCompania;
use Livewire\WithPagination;
use App\Models\Vistas\VtPersonales;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Tabla extends Component
{
    // Importa el trait WithPagination para manejar la paginación de datos
    use WithPagination;

    // Define el tema de paginación como 'bootstrap'
    protected $paginationTheme = 'bootstrap';

    // ===========================
    // Propiedades para búsqueda y filtrado en tiempo real
    // ===========================

    public $buscarNombrecompleto = ''; // Almacena el criterio de búsqueda por nombre completo
    public $buscarCodigo = '';         // Almacena el criterio de búsqueda por código
    public $buscarDocumento = '';      // Almacena el criterio de búsqueda por documento
    public $buscarFechajuramento = ''; // Almacena el criterio de búsqueda por fecha_juramento
    public $buscarCategoriaId = "";      // Almacena el criterio de búsqueda por categoría
    public $buscarEstadoId = '';         // Almacena el criterio de búsqueda por Estado
    public $buscarEstadoActualizarId = ''; // Almacena el criterio de búsqueda por estado_actualizar
    public $buscarPaisId = '';           // Almacena el criterio de búsqueda por Pais
    public $buscarSexoId = '';           // Almacena el criterio de búsqueda por Sexo
    public $buscarGrupoSanguineoId = ''; // Almacena el criterio de búsqueda por Sexo
    public $buscarCompaniaId = '';       // Almacena el criterio de búsqueda por compañía
    public $paginado = 5;              // Define la cantidad de registros a mostrar por página

    // Propiedades para los select del filtro
    public $categorias, $estados, $estados_actualizar, $paises, $sexos, $gruposSanguineos, $companias;

    public function mount()
    {
        $this->categorias = Categoria::select('idpersonal_categorias', 'categoria')->get();

        $this->estados = Estado::select('idpersonal_estados', 'estado')->get();

        $this->estados_actualizar = EstadoActualizar::select('idpersonal_estado_actualizar', 'estado')->get();

        $this->paises = Pais::select('idpaises', 'pais')->get();

        $this->sexos = Sexo::select('idpersonal_sexo', 'sexo')->get();

        $this->gruposSanguineos = GrupoSanguineo::select('idpersonal_grupo_sanguineo', 'grupo_sanguineo')->get();

        $this->companias = Compania::select('idcompanias', 'compania')->orderBy('orden')->get();
    }

    /**
     * Método que se ejecuta al actualizar una de las propiedades de búsqueda o paginación.
     * Si se detecta un cambio en alguna de estas propiedades, se resetea la paginación
     * para evitar inconsistencias en los resultados mostrados.
     */
    public function updating($key): void
    {
        if ($key === 'buscarNombrecompleto' || $key === 'buscarCodigo' || $key === 'buscarDocumento' || $key === 'buscarFechajuramento' || $key === 'buscarCategoriaId' || $key === 'buscarEstadoId' || $key === 'buscarEstadoActualizarId' || $key === 'buscarPaisId' || $key === 'buscarSexoId' || $key === 'buscarGrupoSanguineoId' || $key === 'buscarCompaniaId' || $key === 'paginado') {
            $this->resetPage();
        }
    }

    public function render()
    {
        $usuario = Auth::user();
        $usuarioRoles = $usuario->roles()->where('name', 'like', 'personal_%')->pluck('name')->first();
        //$personales = VtPersonales::query();
        switch ($usuarioRoles) {
            case 'personal_moderador_compania':
                $personales = VtPersonales::query()->where('compania_id', $usuario->personal->compania_id);
                break;
            case 'personal_moderador_por_compania':
                $asignacion = UserRoleCompania::where('usuario_id', $usuario->id_usuario)->first();
                $personales = VtPersonales::query()->where('compania_id', $asignacion->compania_id);
                break;

            default:
                $personales = VtPersonales::query();
                break;
        }

        // Aplicar el filtro de compañía si no es moderador
        // if ($usuario->hasRole('moderador_personal_compania')) {
        //     $personales->where('compania_id', $usuario->personal->compania_id);
        // }

        // Continuar con el resto de los filtros en la MISMA query
        $personales = $personales
            ->buscarNombrecompleto($this->buscarNombrecompleto)
            ->buscarCodigo($this->buscarCodigo)
            ->buscarDocumento($this->buscarDocumento)
            ->buscarFechajuramento($this->buscarFechajuramento)
            ->buscarCategoriaId($this->buscarCategoriaId)
            ->buscarEstadoId($this->buscarEstadoId)
            ->buscarEstadoActualizarId($this->buscarEstadoActualizarId)
            ->buscarPaisId($this->buscarPaisId)
            ->buscarSexoId($this->buscarSexoId)
            ->buscarGrupoSanguineoId($this->buscarGrupoSanguineoId)
            //->buscarCompania($this->buscarCompania)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->paginate($this->paginado);

        return view('livewire.personal.tabla', compact('personales'));
    }

    public function excel()
    {
        $datos = VtPersonales::select(
            'nombrecompleto',
            'codigo',
            'documento',
            'fecha_juramento',
            'fecha_de_juramento',
            'categoria',
            'estado',
            'estado_actualizar',
            'pais',
            'sexo',
            'grupo_sanguineo',
            'compania'
        )
            ->buscarNombrecompleto($this->buscarNombrecompleto)
            ->buscarCodigo($this->buscarCodigo)
            ->buscarDocumento($this->buscarDocumento)
            ->buscarFechajuramento($this->buscarFechajuramento)
            ->buscarCategoriaId($this->buscarCategoriaId)
            ->buscarEstadoId($this->buscarEstadoId)
            ->buscarEstadoActualizarId($this->buscarEstadoActualizarId)
            ->buscarPaisId($this->buscarPaisId)
            ->buscarSexoId($this->buscarSexoId)
            ->buscarGrupoSanguineoId($this->buscarGrupoSanguineoId)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->get();
        $encabezados = [
            'Nombre Completo',
            'Codigo',
            'Documento',
            'Año Juramento',
            'Fecha Juramento',
            'Categoria',
            'Estado',
            'Actualizar',
            'Nacionalidad',
            'Sexo',
            'Grupo Sanguineo',
            'Compañia'
        ];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Personal CBVP.xlsx');
    }
}
