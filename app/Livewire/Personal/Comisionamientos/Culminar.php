<?php

namespace App\Livewire\Personal\Comisionamientos;

use App\Models\Personal\Comisionamiento;
use App\Models\Vistas\Personal\VtComisionamiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Culminar extends Component
{
    public $comisionamiento;

    // Propiedades del Formulario
    #[Validate()]
    public $fecha_fin;

    public function mount(VtComisionamiento $comisionamiento)
    {
        $this->comisionamiento = $comisionamiento;
        $this->fecha_fin = Carbon::now()->toDateString();
    }

    public function cancelar()
    {
        $this->redirectRoute('personal.comisionamientos.index');
    }

    protected function rules()
    {
        return [
            'fecha_fin' => [
                'required',
                'date',
                Rule::date()->beforeOrEqual(today()),
                function ($attribute, $value, $fail) {
                    if ($value < $this->comisionamiento->fecha_inicio) {
                        $fail('La fecha de finalización no puede ser anterior a la fecha de inicio del comisionamiento (' . $this->comisionamiento->fecha_inicio->format('d/m/Y') . ').');
                    }
                },
            ]
        ];
    }

    public function culminar()
    {
        $this->validate();
        Comisionamiento::findOrFail($this->comisionamiento->id_comisionamiento)
        ->update([
            'fecha_fin' => $this->fecha_fin ?? null,
            'culminado' => true,
            'actualizadoPor' => Auth::id(),
        ]);
        session()->flash('success', 'Comisionamiento Finalizado!');
        $this->redirectRoute('personal.comisionamientos.index');
    }

    public function render()
    {
        return view('livewire.personal.comisionamientos.culminar');
    }
}
