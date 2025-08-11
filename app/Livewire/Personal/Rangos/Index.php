<?php

namespace App\Livewire\Personal\Rangos;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Personal\Rango;
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
    // public $companias;

    // Variables para el formulario
    public $rango_id;
    #[Validate]
    public $rango;

    // Variables para la paginación, busqueda y estado(modo) del formulario
    public $modo = 'inicio'; // inicio, agregar, modificar, seleccionado
    public $buscador = '';
    public $paginado = 5;

    public function mount()
    {
        //
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
        $rango = Rango::findOrFail($id);
        $this->rango_id = $rango->id_rango;
        $this->rango = $rango->rango;
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
        if ($this->rango_id) {
            Rango::destroy($this->rango_id);
            $this->resetearForm();
        }
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'rango' => ['required', Rule::unique(Rango::class)->ignore($this->rango_id, 'id_rango')],
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
            Rango::create($validados);
            session()->flash('success', 'Registro Agregado Correctamente!');
            //$this->redirectRoute('admin.companias.index');
        } elseif ($this->modo === 'modificar' && $this->rango_id) {
            $validados['actualizadoPor'] =  Auth::id();
            Rango::findOrFail($this->rango_id)->update($validados);
            session()->flash('success', 'Registro Actualizado Correctamente!');
        }

        $this->resetearForm();
    }

    // Restablecer formulario a deshabilitado y limpiar datos ingresados o seleccionados
    private function resetearForm()
    {
        $this->rango_id = null;
        $this->rango = null;
        $this->modo = 'inicio';
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscador',
            'paginado',
        ])) {
            $this->resetPage('rangos_page');
        }
    }

    public function render()
    {
        return view('livewire.personal.rangos.index', [
            'rangos' => Rango::select('id_rango', 'rango')
                ->buscador($this->buscador)
                ->orderBy('rango')
                ->paginate($this->paginado, ['*'], 'rangos_page')
        ]);
    }

    // Obtener lo datos para los reportes pdf y excel
    public function datosParaExportar()
    {
        return Rango::select([
            'rango',
        ])
            ->buscador($this->buscador)
            ->orderBy('rango')
            ->get();
    }

    public function excel()
    {
        $datos = $this->datosParaExportar();
        $encabezados = ['Rangos'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Listado de Rangos - CBVP.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Listado de Rangos - CBVP";
        $datos = $this->datosParaExportar();
        $encabezados = ['Rangos'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
