<?php

namespace App\Livewire\Materiales\EquipoHidraulico\Herramientas;

use App\Models\Materiales\EquipoHidraulico\Herramienta\Tipo;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Tipos extends Component
{
    // Usar el trait WithPagination para la paginación
    use WithPagination;

    // Variables para el formulario
    public $tipo_id;
    #[Validate]
    public $tipo;

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
        $tipo = Tipo::findOrFail($id);
        $this->tipo_id = $tipo->idhidraulico_herr_tipo;
        $this->tipo = $tipo->tipo;
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
        if ($this->tipo_id) {
            Tipo::destroy($this->tipo_id);
            $this->resetearForm();
        }
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'tipo' => ['required', 'max:45', Rule::unique(Tipo::class)->ignore($this->tipo_id, 'idhidraulico_herr_tipo')],
        ];
    }

    public function grabar()
    {
        // Validar los datos
        $validados = $this->validate();

        if ($this->modo === 'agregar') {
            Tipo::create($validados);
        } elseif ($this->modo === 'modificar' && $this->tipo_id) {
            Tipo::findOrFail($this->tipo_id)->update($validados);
        }

        $this->resetearForm();
    }

    // Restablecer formulario a deshabilitado y limpiar datos ingresados o seleccionados
    private function resetearForm()
    {
        $this->tipo_id = null;
        $this->tipo = '';
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
        return view('livewire.materiales.equipo-hidraulico.herramientas.tipos', [
            'tipos' => Tipo::select('idhidraulico_herr_tipo', 'tipo')
                ->buscador($this->buscador)->orderBy('tipo', 'asc')->paginate($this->paginado),
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
