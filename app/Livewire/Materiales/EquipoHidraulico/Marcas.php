<?php

namespace App\Livewire\Materiales\EquipoHidraulico;

use App\Models\Materiales\EquipoHidraulico\Marca;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Marcas extends Component
{
    // Usar el trait WithPagination para la paginación
    use WithPagination;

    // Variables para el formulario
    public $marca_id;
    #[Validate]
    public $marca;

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
        $marca = Marca::findOrFail($id);
        $this->marca_id = $marca->id_hidraulico_marca;
        $this->marca = $marca->marca;
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
        if ($this->marca_id) {
            Marca::destroy($this->marca_id);
            $this->resetearForm();
        }
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'marca' => ['required', 'max:45', Rule::unique(Marca::class)->ignore($this->marca_id, 'id_hidraulico_marca')],
        ];
    }

    public function grabar()
    {
        // Validar los datos
        $validados = $this->validate();

        if ($this->modo === 'agregar') {
            Marca::create($validados);
        } elseif ($this->modo === 'modificar' && $this->marca_id) {
            Marca::findOrFail($this->marca_id)->update($validados);
        }

        $this->resetearForm();
    }

    // Restablecer formulario a deshabilitado y limpiar datos ingresados o seleccionados
    private function resetearForm()
    {
        $this->marca_id = null;
        $this->marca = '';
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
        return view('livewire.materiales.equipo-hidraulico.marcas', [
            'marcas' => Marca::select('id_hidraulico_marca', 'marca')
                ->buscador($this->buscador)->orderBy('marca', 'asc')->paginate($this->paginado),
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
