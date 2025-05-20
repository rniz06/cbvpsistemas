<?php

namespace App\Livewire\Materiales\Mayor;

use App\Models\Movil\Modelo;
use App\Models\Movil\Marca;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Modelos extends Component
{
    // Usar el trait WithPagination para la paginación
    use WithPagination;

    // Variables para el formulario
    public $marca_id;
    public $modelo_id;
    #[Validate]
    public $modelo;

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
        $modelo = Modelo::findOrFail($id);
        $this->modelo_id = $modelo->id_movil_modelo;
        $this->modelo = $modelo->modelo;
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
        if ($this->modelo_id) {
            Modelo::destroy($this->modelo_id);
            $this->resetearForm();
        }
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'modelo' => ['required', 'max:45'],
        ];
    }

    public function grabar()
    {
        // Validar los datos
        $validados = $this->validate();

        if ($this->modo === 'agregar') {
            Modelo::create([
                'modelo' => $validados['modelo'],
                'marca_id' => $this->marca_id
            ]);
        } elseif ($this->modo === 'modificar' && $this->modelo_id) {
            Modelo::findOrFail($this->modelo_id)->update([
                'modelo' => $validados['modelo'],
            ]);
        }

        $this->resetearForm();
    }

    // Restablecer formulario a deshabilitado y limpiar datos ingresados o seleccionados
    private function resetearForm()
    {
        $this->modelo_id = null;
        $this->modelo = '';
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
        return view('livewire.materiales.mayor.modelos', [
            'modelos' => Modelo::select('id_movil_modelo', 'modelo', 'marca_id', 'activo')->where('marca_id', $this->marca_id)
                ->buscador($this->buscador)->orderBy('modelo', 'asc')->paginate($this->paginado),
            'marca' => Marca::findOrFail($this->marca_id),
        ]);
    }

    public function cambiarEstado($id, $nuevoEstado)
    {
        $modelo = Modelo::find($id);

        if ($modelo) {
            $modelo->activo = $nuevoEstado;
            $modelo->save();
        }

        session()->flash('success', 'El estado se actualizó correctamente.');
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
