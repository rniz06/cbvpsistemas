<?php

namespace App\Livewire\Admin;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Admin\CompaniaGral;
use App\Models\Gral\Direccion;
use App\Models\Vistas\Gral\VtDireccion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Direcciones extends Component
{
    // Usar el trait WithPagination para la paginación
    use WithPagination;

    // Propiedad para los filtros
    public $companias;

    // Variables para el formulario
    public $direccion_id;
    #[Validate]
    public $direccion, $compania_id;

    // Variables para la paginación, busqueda y estado(modo) del formulario
    public $modo = 'inicio'; // inicio, agregar, modificar, seleccionado
    public $buscador = '';
    public $buscarDireccion = '';
    public $buscarCompaniaId = '';
    public $paginado = 5;

    public function mount()
    {
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
        $direccion = Direccion::findOrFail($id);
        $this->direccion_id = $direccion->id_direccion;
        $this->direccion = $direccion->direccion;
        $this->compania_id = $direccion->compania_id;
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
        if ($this->direccion_id) {
            Direccion::destroy($this->direccion_id);
            $this->resetearForm();
        }
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'direccion' => [
                'required',
                Rule::unique(Direccion::class, 'direccion')
                    ->ignore($this->direccion_id, 'id_direccion') // Ignora el actual si estás actualizando
                    ->where(function ($query) {
                        return $query->where('compania_id', $this->compania_id);
                    }),
            ],
            'compania_id' => [
                'required',
                Rule::exists(CompaniaGral::class, 'id_compania'),
            ],
        ];
    }

    // Personalizar mensajes de validacion
    protected function messages()
    {
        return [
            'direccion.unique' => 'Esta Direccion ya ha sido registrada en ese estamento.'
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
            Direccion::create($validados);
            session()->flash('success', 'Registro Agregado Correctamente!');
            //$this->redirectRoute('admin.companias.index');
        } elseif ($this->modo === 'modificar' && $this->direccion_id) {
            $validados['actualizadoPor'] =  Auth::id();
            Direccion::findOrFail($this->direccion_id)->update($validados);
            session()->flash('success', 'Registro Actualizado Correctamente!');
        }

        $this->resetearForm();
    }

    // Restablecer formulario a deshabilitado y limpiar datos ingresados o seleccionados
    private function resetearForm()
    {
        $this->direccion_id = null;
        $this->direccion = null;
        $this->compania_id = null;
        $this->modo = 'inicio';
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'buscador',
            'paginado',
            'buscarDireccion',
            'buscarCompaniaId',
        ])) {
            $this->resetPage('direcciones_page');
        }
    }

    public function render()
    {
        return view('livewire.admin.direcciones', [
            'direcciones' => VtDireccion::select('id_direccion', 'direccion', 'compania_id', 'compania')
                ->buscador($this->buscador)
                ->buscarDireccion($this->buscarDireccion)
                ->buscarCompaniaId($this->buscarCompaniaId)
                ->orderBy('direccion')
                ->paginate($this->paginado, ['*'], 'direcciones_page')
        ]);
    }

    // Obtener lo datos para los reportes pdf y excel
    public function datosParaExportar()
    {
        return VtDireccion::select([
            'direccion',
            'compania',
        ])
            ->buscador($this->buscador)
            ->buscarDireccion($this->buscarDireccion)
            ->buscarCompaniaId($this->buscarCompaniaId)
            ->orderBy('direccion')
            ->get();
    }


    // FALTA COMPLETAR
    public function excel()
    {
        $datos = $this->datosParaExportar();
        $encabezados = ['Direcciones', 'Pertenece a:'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Listado de Direcciones - CBVP.xlsx');
    }

    public function pdf()
    {
        $nombre_archivo = "Listado de Direcciones - CBVP";
        $datos = $this->datosParaExportar();
        $encabezados = ['Direcciones', 'Pertenece a:'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
