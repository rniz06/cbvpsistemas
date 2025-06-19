<?php

namespace App\Livewire\Materiales\EquipoHidraulico;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Livewire\Materiales\EquipoHidraulico\Herramientas\Motor as HerramientasMotor;
use App\Models\Materiales\EquipoHidraulico\Motor as EquipoHidraulicoMotor;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class Motor extends Component
{
    // Usar el trait WithPagination para la paginación
    use WithPagination;

    // Variables para el formulario
    public $motor_id;
    #[Validate]
    public $motor;

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
        $motor = EquipoHidraulicoMotor::findOrFail($id);
        $this->motor_id = $motor->id_hidraulico_motor;
        $this->motor = $motor->motor;
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
        if ($this->motor_id) {
            EquipoHidraulicoMotor::destroy($this->motor_id);
            $this->resetearForm();
        }
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'motor' => ['required', 'max:45', Rule::unique(EquipoHidraulicoMotor::class)->ignore($this->motor_id, 'id_hidraulico_motor')],
        ];
    }

    public function grabar()
    {
        // Validar los datos
        $validados = $this->validate();

        if ($this->modo === 'agregar') {
            EquipoHidraulicoMotor::create($validados);
        } elseif ($this->modo === 'modificar' && $this->motor_id) {
            EquipoHidraulicoMotor::findOrFail($this->motor_id)->update($validados);
        }

        $this->resetearForm();
    }

    // Restablecer formulario a deshabilitado y limpiar datos ingresados o seleccionados
    private function resetearForm()
    {
        $this->motor_id = null;
        $this->motor = '';
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
        return view('livewire.materiales.equipo-hidraulico.motor', [
            'motores' => EquipoHidraulicoMotor::select('id_hidraulico_motor', 'motor')
                ->buscador($this->buscador)->orderBy('motor', 'asc')->paginate($this->paginado),
        ]);
    }
    
    // public function excel()
    // {
    //     $datos = VtProveedor::select('prov_razonsocial', 'prov_ruc', 'prov_direccion', 'prov_telefono', 'prov_correo', 'ciu_descripcion')->get();
    //     $encabezados = ['Razon Social', 'Ruc', 'Dirección', 'Teléfono', 'Correo', 'Ciudad'];

    //     return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Proveedores.xlsx');
    // }

    // public function pdf()
    // {
    //     $nombre_archivo = "Proveedores";
    //     $datos = VtProveedor::select('prov_razonsocial', 'prov_ruc', 'prov_direccion', 'prov_telefono', 'prov_correo', 'ciu_descripcion')->get();
    //     $encabezados = ['Razon Social', 'Ruc', 'Dirección', 'Teléfono', 'Correo', 'Ciudad'];

    //     return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    // }
}