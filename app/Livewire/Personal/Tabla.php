<?php

namespace App\Livewire\Personal;

use App\Models\Role;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Vistas\VtCompania;
use App\Models\Vistas\VtUsers;
use Livewire\Attributes\On;
use Livewire\Component;

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
    public $buscarCategoria = '';      // Almacena el criterio de búsqueda por categoría
    public $buscarCompania = '';       // Almacena el criterio de búsqueda por compañía
    public $paginado = 5;              // Define la cantidad de registros a mostrar por página

    /**
     * Método que se ejecuta al actualizar una de las propiedades de búsqueda o paginación.
     * Si se detecta un cambio en alguna de estas propiedades, se resetea la paginación
     * para evitar inconsistencias en los resultados mostrados.
     */
    public function updating($key)
    {
        if (in_array($key, ['buscarNombrecompleto', 'buscarCodigo', 'buscarDocumento', 'buscarCategoria', 'buscarCompania', 'paginado'])) {
            $this->resetPage();
        }
    }

    /**
     * Método encargado de obtener y renderizar los datos.
     * Se realiza la consulta a la tabla VtUsers aplicando los filtros de búsqueda
     * y paginando los resultados según la cantidad definida en $paginado.
     */
    public function render()
    {
        $usuarios = VtUsers::select('id_user', 'nombrecompleto', 'codigo', 'documento', 'categoria', 'compania')
            ->buscarNombrecompleto($this->buscarNombrecompleto) // Aplica filtro por nombre completo
            ->buscarCodigo($this->buscarCodigo)                 // Aplica filtro por código
            ->buscarDocumento($this->buscarDocumento)           // Aplica filtro por documento
            ->buscarCategoria($this->buscarCategoria)           // Aplica filtro por categoría
            ->buscarCompania($this->buscarCompania)             // Aplica filtro por compañía
            ->paginate($this->paginado);                        // Pagina los resultados

        // Retorna la vista 'livewire.personal.tabla' con los datos de los usuarios
        return view('livewire.personal.tabla', compact('usuarios'));
    }
}
