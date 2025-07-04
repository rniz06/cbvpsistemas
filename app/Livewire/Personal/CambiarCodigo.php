<?php

namespace App\Livewire\Personal;

use App\Models\Personal;
use App\Models\Vistas\VtPersonales;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CambiarCodigo extends Component
{
    public $personal;

    public $codigo_a_asignar;

    public function mount(VtPersonales $personal)
    {
        $this->personal = $personal;
    }

    protected function rules()
    {
        return [
            'codigo_a_asignar' => ['required', 'numeric', 'min_digits:1', 'max_digits:5'],
        ];
    }

    public function guardar()
    {
        $this->validate();
        $personal = Personal::where('idpersonal', $this->personal->idpersonal)->first();
        $personal->update([
            'codigo' => $this->codigo_a_asignar
        ]);
        session()->flash('success', 'Codigo Actualizado Correctamente!');
        $this->redirectRoute('personal.show', ['personal' => $this->personal->idpersonal]);
    }

    public function render()
    {
        return view('livewire.personal.cambiar-codigo', [
            'codigoDetalles' => VtPersonales::where([['categoria_id', $this->personal->categoria_id],['codigo', $this->codigo_a_asignar]])
            ->selectRaw("CONCAT(nombrecompleto, ' - ', codigo, ' - ', categoria, ' - ', compania) AS codigoDetalles")->first()
        ]);
    }
}
