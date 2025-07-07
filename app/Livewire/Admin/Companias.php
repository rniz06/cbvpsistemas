<?php

namespace App\Livewire\Admin;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\CiudadGral;
use App\Models\Admin\CompaniaGral;
use App\Models\Admin\DepartamentoGral;
use App\Models\Admin\RegionGral;
use App\Models\Vistas\GralVtCompania;
use App\Models\Vistas\VtCompania;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Companias extends Component
{
    // Usar el trait WithPagination para la paginación
    use WithPagination;

    // Propiedad para los filtros
    public $ciudades, $regiones, $departamentos;

    // Variables para el formulario
    public $compania_id;
    #[Validate]
    public $compania, $ciudad_id, $region_id, $orden;

    // Variables para la paginación, busqueda y estado(modo) del formulario
    public $modo = 'inicio'; // inicio, agregar, modificar, seleccionado
    public $buscador = '';
    public $buscarCompania = '';
    public $buscarDepartamentoId = '';
    public $buscarCiudadId = '';
    public $buscarRegionId = '';
    public $paginado = 5;

    public function mount()
    {
        $this->regiones = RegionGral::select('id_region', 'region')->get();
        $this->departamentos = DepartamentoGral::select('id_departamento', 'departamento')->get();
        $this->ciudades = CiudadGral::select('id_ciudad', 'ciudad', 'departamento_id')
            ->when($this->buscarDepartamentoId, function ($query) {
                return $query->where('departamento_id', $this->buscarDepartamentoId);
            })
            ->orderBy('ciudad')
            ->get();
    }

    public function updatedBuscarDepartamentoId($value)
    {
        $this->ciudades = CiudadGral::select('id_ciudad', 'ciudad', 'departamento_id')
            ->when($value, function ($query) use ($value) {
                return $query->where('departamento_id', $value);
            })
            ->orderBy('ciudad')
            ->get();

        // Resetear la selección de ciudad cuando cambia el departamento
        $this->buscarCiudadId = '';
    }

    // Habilita el formulario para agregar un registro
    public function agregar()
    {
        $this->resetearForm();
        $this->modo = 'agregar';
    }

    // Habilita los botones de editar, eliminar y cancelar
    public function seleccionado($id)
    {
        $compania = CompaniaGral::findOrFail($id);
        $this->compania_id = $compania->id_compania;
        $this->compania = $compania->compania;
        $this->ciudad_id = $compania->ciudad_id;
        $this->region_id = $compania->region_id;
        $this->orden = $compania->orden;
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
        if ($this->compania_id) {
            CompaniaGral::destroy($this->compania_id);
            $this->resetearForm();
        }
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'compania' => ['required', Rule::unique(CompaniaGral::class, 'compania')->ignore($this->compania_id, 'id_compania')],
            'ciudad_id' => ['required', Rule::exists(CiudadGral::class, 'id_ciudad')],
            'region_id' => ['required', Rule::exists(RegionGral::class, 'id_region')],
            'orden' => ['required', Rule::unique(CompaniaGral::class, 'orden')->ignore($this->compania_id, 'id_compania')],
        ];
    }

    public function modometodo()
    {
        $this->emit('modometodo', $this->modo);
    }

    public function grabar()
    {
        // Validar los datos
        $validados = $this->validate();

        if ($this->modo === 'agregar') {
            //return dd($validados);
            CompaniaGral::create($validados);
            session()->flash('success', 'Registro Agregado Correctamente!');
            //$this->redirectRoute('admin.companias.index');
        } elseif ($this->modo === 'modificar' && $this->compania_id) {
            CompaniaGral::findOrFail($this->compania_id)->update($validados);
            session()->flash('success', 'Registro Actualizado Correctamente!');
        }

        $this->resetearForm();
    }

    // Restablecer formulario a deshabilitado y limpiar datos ingresados o seleccionados
    private function resetearForm()
    {
        $this->compania_id = null;
        $this->compania = '';
        $this->ciudad_id = '';
        $this->region_id = '';
        $this->orden = '';
        $this->modo = 'inicio';
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    // public function updating($key): void
    // {
    //     if ($key === 'buscador' || $key === 'paginado' || $key === 'companias_page' || $key === 'buscarDepartamentoId' || $key === 'buscarCiudadId' || $key === 'buscarRegionId') {
    //         $this->resetPage();
    //     }
    // }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscador',
            'paginado',
            'buscarDepartamentoId',
            'buscarCiudadId',
            'buscarRegionId',
        ])) {
            $this->resetPage('companias_page');
        }
    }

    public function render()
    {
        return view('livewire.admin.companias', [
            'companias' => GralVtCompania::select('id_compania', 'compania', 'departamento', 'ciudad', 'region')
            ->buscador($this->buscador)
                ->buscarCompania($this->buscarCompania)
                ->buscarDepartamentoId($this->buscarDepartamentoId)
                ->buscarCiudadId($this->buscarCiudadId)
                ->buscarRegionId($this->buscarRegionId)
                ->orderBy('orden')
                ->paginate($this->paginado, ['*'], 'companias_page')
        ]);
    }

    public function excel()
    {
        $datos = GralVtCompania::select('compania', 'departamento', 'ciudad', 'region')
            ->buscarCompania($this->buscarCompania)
            ->buscarDepartamentoId($this->buscarDepartamentoId)
            ->buscarCiudadId($this->buscarCiudadId)
            ->buscarRegionId($this->buscarRegionId)->orderBy('orden')->get();
        $encabezados = ['Compañia', 'Departamento', 'Ciudad', 'Region'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Listado de Compañias.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Listado de Compañias";
        $datos = GralVtCompania::select('compania', 'departamento', 'ciudad', 'region')
            ->buscarCompania($this->buscarCompania)
            ->buscarDepartamentoId($this->buscarDepartamentoId)
            ->buscarCiudadId($this->buscarCiudadId)
            ->buscarRegionId($this->buscarRegionId)->orderBy('orden')->get();
        $encabezados = ['Compañia', 'Departamento', 'Ciudad', 'Region'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
