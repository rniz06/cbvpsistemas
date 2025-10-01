<?php

namespace App\Livewire\Usuarios;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Admin\CompaniaGral;
use App\Models\Personal\Categoria;
use App\Models\Role;
use Livewire\WithPagination;
use App\Models\Vistas\VtUsuario;
use App\Models\Vistas\VtUsuarioConRole;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Tabla extends Component
{
    // Propiedades para los select
    public $categorias = [], $companias = [], $roles = [];

    public function mount()
    {
        $this->categorias = Categoria::select('idpersonal_categorias', 'categoria')->get();
        $this->companias  = CompaniaGral::select('id_compania', 'compania')->orderBy('orden', 'asc')->get();
    }

    // Importa el trait WithPagination para manejar la paginación de datos
    use WithPagination;

    // Define el tema de paginación como 'bootstrap'
    protected $paginationTheme = 'bootstrap';

    // ===========================
    // Propiedades para búsqueda y filtrado en tiempo real
    // ===========================

    public $buscador = '';
    public $buscarNombrecompleto = ''; // Almacena el criterio de búsqueda por nombre completo
    public $buscarCodigo = '';         // Almacena el criterio de búsqueda por código
    public $buscarDocumento = '';      // Almacena el criterio de búsqueda por documento
    public $buscarCategoriaId = '';      // Almacena el criterio de búsqueda por categoría
    public $buscarCompaniaId = '';       // Almacena el criterio de búsqueda por compañía
    public $buscarRoles = '';          // Almacena el criterio de búsqueda por roles
    public $paginado = 5;              // Define la cantidad de registros a mostrar por página

    /**
     * Método que se ejecuta al actualizar una de las propiedades de búsqueda o paginación.
     * Si se detecta un cambio en alguna de estas propiedades, se resetea la paginación
     * para evitar inconsistencias en los resultados mostrados.
     */
    public function updating($key)
    {
        if (in_array($key, ['buscarNombrecompleto', 'buscarCodigo', 'buscarDocumento', 'buscarCategoriaId', 'buscarCompaniaId', 'buscarRoles', 'paginado'])) {
            $this->resetPage('usuarios_page');
        }
    }

    public function render()
    {
        $usuario = Auth::user();
        $usuarioRoles = $usuario->roles()->pluck('name')->first();
        switch ($usuarioRoles) {
            case 'SuperAdmin':
                $this->roles = Role::select('name')->get();
                break;
            case 'personal_admin':
                $this->roles = Role::select('name')->where('name', 'like', 'personal_%')->where('name', '!=', 'SuperAdmin')->get();
                break;
            case 'materiales_admin':
                $this->roles = Role::select('name')->where('name', 'like', 'materiales_%')->where('name', '!=', 'SuperAdmin')->get();
                break;
            default:
                $this->roles = [];
                break;
        }
        $usuarios = VtUsuarioConRole::select('id_usuario', 'nombrecompleto', 'codigo', 'documento', 'categoria', 'compania', 'roles', 'ultimo_acceso')
            ->buscador($this->buscador)
            ->buscarNombrecompleto($this->buscarNombrecompleto)
            ->buscarCodigo($this->buscarCodigo)
            ->buscarDocumento($this->buscarDocumento)
            ->buscarCategoriaId($this->buscarCategoriaId)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->orderBy('codigo')
            ->buscarRoles($this->buscarRoles)
            // condición para excluir SuperAdmin si el usuario no es SuperAdmin
            ->when($usuarioRoles !== 'SuperAdmin', function ($query) {
                $query->whereNotIn('codigo', [8699, 7802]); // Marcos, Fredy
            })
            ->paginate($this->paginado, ['*'], 'usuarios_page');

        return view('livewire.usuarios.tabla', [
            'usuarios' => $usuarios
        ]);
    }

    // Obtener lo datos para los reportes pdf y excel
    public function cargarDatosParaExportar()
    {
        return VtUsuarioConRole::select([
            'nombrecompleto',
            'codigo',
            'documento',
            'categoria',
            'compania',
            'roles',
            //'ultimo_acceso',
        ])
            ->buscador($this->buscador)
            ->buscarNombrecompleto($this->buscarNombrecompleto)
            ->buscarCodigo($this->buscarCodigo)
            ->buscarDocumento($this->buscarDocumento)
            ->buscarCategoriaId($this->buscarCategoriaId)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->orderBy('codigo')
            ->buscarRoles($this->buscarRoles)
            ->get();
    }

    public function excel()
    {
        $datos = $this->cargarDatosParaExportar();
        $encabezados = ['Nombre Completo.', 'Código', 'Documento', 'Categoria', 'Compañia', 'Roles'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Listado de Usuarios Sinabom - CBVP.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Listado de Usuarios Sinabom - CBVP";
        $datos = $this->cargarDatosParaExportar();
        $encabezados = ['Nombre C.', 'Código', 'Doc.', 'Categoria', 'Compañia', 'Roles'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
