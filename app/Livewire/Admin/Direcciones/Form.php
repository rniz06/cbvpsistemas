<?php

namespace App\Livewire\Admin\Direcciones;

use App\Models\Admin\CompaniaGral;
use App\Models\Gral\Direccion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Form extends Component
{
    public $direccion_id;
    public $direccion, $compania_id;
    public $modo = 'inicio'; // inicio, agregar, modificar, seleccionado

    public $companias = [];

    protected $listeners = ['direccionSeleccionado' => 'cargarDireccion'];

    public function mount()
    {
        $this->companias = CompaniaGral::select('id_compania', 'compania')
            ->whereIn('compania',['DIRECTORIO', 'COMANDANCIA', 'ANB'])->get();
    }

    protected function rules()
    {
        return [
            'direccion' => ['required', Rule::unique(Direccion::class)->ignore($this->direccion_id, 'id_direccion')],
            'compania_id' => ['required', Rule::exists(CompaniaGral::class, 'id_compania')],
        ];
    }

    public function agregar()
    {
        $this->resetearForm();
        $this->modo = 'agregar';
    }

    public function cargarDireccion($id)
    {
        $direccion = Direccion::findOrFail($id);

        $this->direccion_id = $direccion->id_direccion;
        $this->direccion = $direccion->direccion;
        $this->compania_id = $direccion->compania_id;
        $this->modo = 'seleccionado';
    }

    public function editar()
    {
        $this->modo = 'modificar';
    }

    public function cancelar()
    {
        $this->resetearForm();
    }

    public function eliminar()
    {
        if ($this->direccion_id) {
            Direccion::destroy($this->direccion_id);
            $this->resetearForm();
            $this->dispatch('direccionActualizado');
        }
    }

    public function grabar()
    {
        $validados = $this->validate();

        if ($this->modo === 'agregar') {
            $validados['creadoPor'] = Auth::id();
            Direccion::create($validados);
        } elseif ($this->modo === 'modificar' && $this->direccion_id) {
            $validados['actualizadoPor'] = Auth::id();
            Direccion::findOrFail($this->direccion_id)->update($validados);
        }

        $this->resetearForm();
        $this->dispatch('direccionActualizado');
    }

    private function resetearForm()
    {
        $this->direccion_id = null;
        $this->direccion = '';
        $this->compania_id = '';
        $this->modo = 'inicio';
    }

    public function render()
    {
        return view('livewire.admin.direcciones.form');
    }
}
