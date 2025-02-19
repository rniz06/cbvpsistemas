<?php

namespace App\Livewire\Personal;

use App\Models\Personal\Categoria;
use App\Models\Vistas\VtCompania;
use Livewire\WithPagination;
use App\Models\Vistas\VtPersonales;
use Illuminate\Support\Facades\Auth;
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
    public $buscarEstadoActualizar = ''; // Almacena el criterio de búsqueda por estado_actualizar
    public $buscarPais = '';           // Almacena el criterio de búsqueda por Pais
    public $buscarSexo = '';           // Almacena el criterio de búsqueda por Sexo
    public $buscarGrupoSanguineo = ''; // Almacena el criterio de búsqueda por Sexo
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
        $usuario = Auth::user();
        $personales = VtPersonales::query();

        // Aplicar el filtro de compañía si no es moderador
        if ($usuario->hasRole('moderador_personal_compania')) {
            $personales->where('compania_id', $usuario->personal->compania_id);
        }

        // Continuar con el resto de los filtros en la MISMA query
        $personales = $personales
            ->buscarNombrecompleto($this->buscarNombrecompleto)
            ->buscarCodigo($this->buscarCodigo)
            ->buscarDocumento($this->buscarDocumento)
            ->buscarFechajuramento($this->buscarFechajuramento)
            ->buscarCategoria($this->buscarCategoria)
            ->buscarEstado($this->buscarEstado)
            ->buscarEstadoActualizar($this->buscarEstadoActualizar)
            ->buscarPais($this->buscarPais)
            ->buscarSexo($this->buscarSexo)
            ->buscarCompania($this->buscarCompania)
            ->paginate($this->paginado);

        return view('livewire.personal.tabla', compact('personales'));
    }
}
