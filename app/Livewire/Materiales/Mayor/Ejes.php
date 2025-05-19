<?php

namespace App\Livewire\Materiales\Mayor;

use App\Models\Movil\Eje;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Ejes extends Component
{
    // Usar el trait WithPagination para la paginación
    use WithPagination;

    // Variables para el formulario
    public $eje_id;
    #[Validate]
    public $eje;

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
        $eje = Eje::findOrFail($id);
        $this->eje_id = $eje->id_movil_eje;
        $this->eje = $eje->eje;
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
        if ($this->eje_id) {
            Eje::destroy($this->eje_id);
            $this->resetearForm();
        }
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'eje' => ['required', 'max:45', Rule::unique('moviles_ejes')->ignore($this->eje_id, 'id_movil_eje')],
        ];
    }

    public function grabar()
    {
        // Validar los datos
        $validados = $this->validate();

        if ($this->modo === 'agregar') {
            Eje::create($validados);
        } elseif ($this->modo === 'modificar' && $this->eje_id) {
            Eje::findOrFail($this->eje_id)->update($validados);
        }

        $this->resetearForm();
    }

    // Restablecer formulario a deshabilitado y limpiar datos ingresados o seleccionados
    private function resetearForm()
    {
        $this->eje_id = null;
        $this->eje = '';
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
        return view('livewire.materiales.mayor.ejes', [
            'ejes' => Eje::select('id_movil_eje', 'eje', 'activo')
                ->buscador($this->buscador)->orderBy('eje', 'asc')->paginate($this->paginado),
        ]);
    }

    public function cambiarEstado($id, $nuevoEstado)
    {
        $eje = Eje::find($id);

        if ($eje) {
            $eje->activo = $nuevoEstado;
            $eje->save();
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
