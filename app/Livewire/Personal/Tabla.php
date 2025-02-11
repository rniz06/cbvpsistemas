<?php

namespace App\Livewire\Personal;

use App\Models\Personal\Categoria;
use Livewire\WithPagination;
use App\Models\Vistas\VtPersonales;
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
    public $buscarFechajuramento = ''; // Almacena el criterio de búsqueda por fecha_juramento
    public $buscarCategoria = "";      // Almacena el criterio de búsqueda por categoría
    public $buscarEstado = '';         // Almacena el criterio de búsqueda por Estado
    public $buscarEstadoActualizar = '';// Almacena el criterio de búsqueda por estado_actualizar
    public $buscarPais = '';           // Almacena el criterio de búsqueda por Pais
    public $buscarSexo = '';           // Almacena el criterio de búsqueda por Sexo
    public $buscarCompania = '';       // Almacena el criterio de búsqueda por compañía
    public $paginado = 5;              // Define la cantidad de registros a mostrar por página

    /**
     * Método que se ejecuta al actualizar una de las propiedades de búsqueda o paginación.
     * Si se detecta un cambio en alguna de estas propiedades, se resetea la paginación
     * para evitar inconsistencias en los resultados mostrados.
     */
    public function updating($key): void
    {
        if ($key === 'buscarNombrecompleto' || $key === 'buscarCodigo' || $key === 'buscarDocumento' || $key === 'buscarFechajuramento' || $key === 'buscarCategoria' || $key === 'buscarEstado' || $key === 'buscarPais' || $key === 'buscarSexo' || $key === 'buscarCompania' || $key === 'paginado') {
            $this->resetPage();
        }
    }

    public function render()
    {
        $personales = VtPersonales::buscarNombrecompleto($this->buscarNombrecompleto) // Aplica filtro por nombre completo
            ->buscarCodigo($this->buscarCodigo)                 // Aplica filtro por código
            ->buscarDocumento($this->buscarDocumento)           // Aplica filtro por documento
            ->buscarFechajuramento($this->buscarFechajuramento) // Aplica filtro por fecha_juramento
            ->buscarCategoria($this->buscarCategoria)           // Aplica filtro por categoria
            ->buscarEstado($this->buscarEstado)                 // Aplica filtro por estado
            ->buscarEstadoActualizar($this->buscarEstadoActualizar)// Aplica filtro por estado
            ->buscarPais($this->buscarPais)                     // Aplica filtro por pais
            ->buscarSexo($this->buscarSexo)                     // Aplica filtro por sexo
            ->buscarCompania($this->buscarCompania)             // Aplica filtro por compañía
            ->paginate($this->paginado);                        // Pagina los resultados
        return view('livewire.personal.tabla', compact('personales'));
    }
}
