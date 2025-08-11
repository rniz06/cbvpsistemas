<?php

namespace App\Livewire\Personal\Cargos;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Admin\CompaniaGral;
use App\Models\Personal\Cargo;
use App\Models\Personal\Rango;
use App\Models\Vistas\Personal\VtCargo;
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

    // Propiedad para los filtros
    public $rangos, $companias;

    // Variables para el formulario
    public $cargo_id;
    #[Validate]
    public $cargo, $sufijo, $rango_id, $compania_id;

    // Variables para la paginación, busqueda y estado(modo) del formulario
    public $modo             = 'inicio'; // inicio, agregar, modificar, seleccionado
    public $buscador         = '';
    public $buscarCargo      = '';
    public $buscarSufijo     = '';
    public $buscarRangoId    = '';
    public $buscarCompaniaId = '';
    public $paginado         = 5;

    public function mount()
    {
        $this->rangos = Rango::select('id_rango', 'rango')->get();
        $this->companias = CompaniaGral::select('id_compania', 'compania')->orderBy('orden')->get();
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
        $cargo             = Cargo::findOrFail($id);
        $this->cargo_id    = $cargo->id_cargo;
        $this->cargo       = $cargo->cargo;
        $this->sufijo      = $cargo->sufijo;
        $this->rango_id    = $cargo->rango_id;
        $this->compania_id = $cargo->compania_id;
        $this->modo        = 'seleccionado';
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
        if ($this->cargo_id) {
            Cargo::destroy($this->cargo_id);
            $this->resetearForm();
        }
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'cargo' => [
                'required',
                Rule::unique(Cargo::class)
                    ->ignore($this->cargo_id, 'id_cargo') // Ignora el actual si estás actualizando
                    ->where(function ($query) {
                        return $query->where('compania_id', $this->compania_id);
                    }),
            ],
            'sufijo'      => ['required', Rule::unique(Cargo::class)->ignore($this->cargo_id, 'id_cargo')],
            'rango_id'    => ['required', Rule::exists(Rango::class, 'id_rango')],
            'compania_id' => ['required', Rule::exists(CompaniaGral::class, 'id_compania')],
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
            $validados['creadoPor'] =  Auth::id();
            Cargo::create($validados);
            session()->flash('success', 'Registro Agregado Correctamente!');
        } elseif ($this->modo === 'modificar' && $this->cargo_id) {
            $validados['actualizadoPor'] =  Auth::id();
            Cargo::findOrFail($this->cargo_id)->update($validados);
            session()->flash('success', 'Registro Actualizado Correctamente!');
        }

        $this->resetearForm();
    }

    // Restablecer formulario a deshabilitado y limpiar datos ingresados o seleccionados
    private function resetearForm()
    {
        $this->cargo_id    = null;
        $this->cargo       = '';
        $this->sufijo      = '';
        $this->rango_id    = '';
        $this->compania_id = '';
        $this->modo        = 'inicio';
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscador',
            'buscarCargo',
            'buscarSufijo',
            'buscarRangoId',
            'buscarCompaniaId',
            'paginado',
        ])) {
            $this->resetPage('cargos_page');
        }
    }

    public function render()
    {
        return view('livewire.personal.cargos.index', [
            'cargos' => VtCargo::select('id_cargo', 'cargo', 'sufijo', 'rango', 'compania')
                ->buscador($this->buscador)
                ->buscarCargo($this->buscarCargo)
                ->buscarSufijo($this->buscarSufijo)
                ->buscarRangoId($this->buscarRangoId)
                ->buscarCompaniaId($this->buscarCompaniaId)
                ->orderBy('sufijo')
                ->paginate($this->paginado, ['*'], 'cargos_page')
        ]);
    }

    // Obtener lo datos para los reportes pdf y excel
    public function datosParaExportar()
    {
        return VtCargo::select('cargo', 'sufijo', 'rango', 'compania')
            ->buscador($this->buscador)
            ->buscarCargo($this->buscarCargo)
            ->buscarSufijo($this->buscarSufijo)
            ->buscarRangoId($this->buscarRangoId)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->orderBy('sufijo')
            ->get();
    }

    public function excel()
    {
        $datos = $this->datosParaExportar();
        $encabezados = ['Cargo', 'Sufijo', 'Rango', 'Estamento'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Listado de Cargos - CBVP.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Listado de Cargos - CBVP";
        $datos = $this->datosParaExportar();
        $encabezados = ['Cargo', 'Sufijo', 'Rango', 'Estamento'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
