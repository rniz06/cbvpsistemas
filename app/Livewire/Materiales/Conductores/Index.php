<?php

namespace App\Livewire\Materiales\Conductores;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Ciudad;
use App\Models\Materiales\Conductor\ClaseLicencia;
use App\Models\Materiales\Conductor\ConductorBombero;
use App\Models\Materiales\Conductor\TipoVehiculo;
use App\Models\Vistas\Materiales\VtConductor;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    // Usar el trait WithPagination para la paginación
    use WithPagination;

    // Variables para el formulario
    public $conductor_id;
    #[Validate]
    public $personal_id, $estado_id, $resolucion, $resolucion_enlace, $fecha_curso, $ciudad_curso_id, $ciudad_licencia_id, $tipo_vehiculo_id, $numero_licencia, $clase_licencia_id;

    // Variables para la paginación, busqueda y estado(modo) del formulario
    public $modo = 'inicio'; // inicio, agregar, modificar, seleccionado
    public $buscador = '';
    public $paginado = 5;

    // Habilita el formulario para agregar un registro
    public function agregar()
    {
        $this->resetearForm();
        $this->modo = 'agregar';
    }

    // Habilita los botones de editar, eliminar y cancelar
    public function seleccionado($id)
    {
        $conductor = ConductorBombero::findOrFail($id);
        $this->conductor_id = $conductor->id_conductor_bombero;
        $this->personal_id = $conductor->personal_id;
        $this->estado_id = $conductor->estado_id;
        $this->resolucion = $conductor->resolucion;
        $this->resolucion_enlace = $conductor->resolucion_enlace;
        $this->fecha_curso = $conductor->fecha_curso;
        $this->ciudad_curso_id = $conductor->ciudad_curso_id;
        $this->ciudad_licencia_id = $conductor->ciudad_licencia_id;
        $this->tipo_vehiculo_id = $conductor->tipo_vehiculo_id;
        $this->numero_licencia = $conductor->numero_licencia;
        $this->clase_licencia_id = $conductor->clase_licencia_id;
        $this->modo = 'seleccionado';
    }

    // Habilita el formulario para editar un registro (La información ya esta cargada por el metodo "seleccionado()")
    public function editar()
    {
        $this->modo = 'modificar';
    }

    // Deshabilita el formulario y borra los datos ingresados o seleccionados
    public function cancelar()
    {
        $this->resetearForm();
    }

    // Elimina el registro que obtuvimos con el metodo "seleccionado()"
    public function eliminar()
    {
        if ($this->proveedor_id) {
            ConductorBombero::destroy($this->proveedor_id);
            $this->resetearForm();
        }
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'personal_id' => ['required', Rule::unique('conductores_bomberos')->ignore($this->conductor_id)],
            'resolucion' => ['required', 'max_digits:50'],
            'resolucion_enlace' => ['nullable', 'max_digits:255'],
            'fecha_curso' => ['required', 'date'],
            'ciudad_curso_id' => ['required'],
            'ciudad_licencia_id' => ['required'],
            'tipo_vehiculo_id' => ['required','exists:conductores_tipo_vehiculo,idconductor_tipo_vehiculo'],
            'numero_licencia' => ['required', Rule::unique('conductores_bomberos')->ignore($this->conductor_id), 'numeric', 'min_digits:6', 'max_digits:7'],
            'clase_licencia_id' => ['required','exists:conductores_clase_licencias,id_conductor_bombero'],
        ];
    }

    public function grabar()
    {
        // Validar los datos
        $validados = $this->validate();

        if ($this->modo === 'agregar') {
            ConductorBombero::create($validados);
        } elseif ($this->modo === 'modificar' && $this->proveedor_id) {
            ConductorBombero::findOrFail($this->proveedor_id)->update($validados);
        }

        $this->resetearForm();
    }

    // Restablecer formulario a deshabilitado y limpiar datos ingresados o seleccionados
    private function resetearForm()
    {
        $this->conductor_id = null;
        $this->personal_id = '';
        $this->estado_id = '';
        $this->resolucion = '';
        $this->resolucion_enlace = '';
        $this->fecha_curso = '';
        $this->ciudad_curso_id = '';
        $this->ciudad_licencia_id = '';
        $this->tipo_vehiculo_id = '';
        $this->numero_licencia = '';
        $this->clase_licencia_id = '';
        $this->modo = 'inicio';
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if ($key === 'buscador' || $key === 'paginado') {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.materiales.conductores.index',[
            'conductores' => VtConductor::select('id_conductor_bombero', 'codigo', 'nombrecompleto', 'compania', 'estado')
                ->buscador($this->buscador)->orderBy('nombrecompleto', 'asc')->paginate($this->paginado),
            'ciudades' => Ciudad::select('idciudades', 'ciudad')->orderBy('ciudad')->get(),
            'tipoVehiculos' => TipoVehiculo::select('idconductor_tipo_vehiculo', 'tipo')->get(),
            'licencias' => ClaseLicencia::select('idconductor_clase_licencia', 'clase')->get(),
        ]);
    }

    public function excel()
    {
        $datos = VtConductor::select('nombrecompleto', 'codigo', 'compania', 'resolucion', 'estado', 'ciudad_curso', 'ciudad_licencia', 'tipo_vehiculo', 'clase_licencia')->get();
        $encabezados = ['Nombre Completo', 'Codigo', 'Compañia', 'Resolución', 'Estado', 'Ciudad Curso', 'Ciudad Licencia', 'Tipo de Vehiculo', 'Clase de Licencia'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Cbvp Conductores.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Cbvp Conductores";
        $datos = VtConductor::select('nombrecompleto', 'codigo', 'compania', 'resolucion', 'estado', 'ciudad_curso', 'ciudad_licencia', 'tipo_vehiculo', 'clase_licencia')->get();
        $encabezados = ['Nombre Completo', 'Codigo', 'Compañia', 'Resolución', 'Estado', 'Ciudad Curso', 'Ciudad Licencia', 'Tipo de Vehiculo', 'Clase de Licencia'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
