<?php

namespace App\Livewire\Materiales\Mayor;

use App\Models\Materiales\Movil\Acronimo;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Acronimos extends Component
{
    // Usar el trait WithPagination para la paginación
    use WithPagination;

    // Variables para el formulario
    public $acronimo_id;
    #[Validate]
    public $tipo, $descripcion;

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
        $acronimo = Acronimo::findOrFail($id);
        $this->acronimo_id = $acronimo->id_movil_tipo;
        $this->tipo = $acronimo->tipo;
        $this->descripcion = $acronimo->descripcion;
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
        if ($this->acronimo_id) {
            Acronimo::destroy($this->acronimo_id);
            $this->resetearForm();
        }
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'tipo' => ['required', 'max:45', Rule::unique('MAT_moviles_tipos')->ignore($this->acronimo_id, 'id_movil_tipo')],
            'descripcion' => ['required', 'max:45'],
        ];
    }

    public function grabar()
    {
        // Validar los datos
        $validados = $this->validate();

        if ($this->modo === 'agregar') {
            Acronimo::create($validados);
        } elseif ($this->modo === 'modificar' && $this->acronimo_id) {
            Acronimo::findOrFail($this->acronimo_id)->update($validados);
        }

        $this->resetearForm();
    }

    // Restablecer formulario a deshabilitado y limpiar datos ingresados o seleccionados
    private function resetearForm()
    {
        $this->acronimo_id = null;
        $this->tipo = '';
        $this->descripcion = '';
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
        return view('livewire.materiales.mayor.acronimos', [
            'acronimos' => Acronimo::select('id_movil_tipo', 'tipo', 'descripcion', 'activo')
                ->buscador($this->buscador)->orderBy('tipo', 'asc')->paginate($this->paginado),
        ]);
    }

    public function cambiarEstado($id, $nuevoEstado)
    {
        $acronimo = Acronimo::find($id);

        if ($acronimo) {
            $acronimo->activo = $nuevoEstado;
            $acronimo->save();
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
