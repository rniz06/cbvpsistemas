<?php

namespace App\Livewire\Materiales\Mayor;

use App\Models\Compania;
use App\Models\Materiales\Accion;
use App\Models\Materiales\Movil\Movil;
use App\Models\Materiales\Movil\MovilComentario;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AgregarAccion extends Component
{
    public $movil_id;
    public $accion_id = '';
    public $compania_id = '';
    public $comentario = '';

    protected $rules = [
        'movil_id' => ['required', 'exists:MAT_moviles,id_movil'],
        'accion_id' => ['required', 'exists:MAT_acciones,id_accion'],
        'comentario' => ['required', 'string', 'max:65535'],
    ];

    public function mount($movil_id)
    {
        $this->movil_id = $movil_id;
    }

    public function guardar()
    {
        $this->validate();
        $movil = Movil::findOrFail($this->movil_id);
        switch ($this->accion_id) {
            case 1:
                $movil->update([
                    'operativo' => 1,
                    'operatividad_id' => 1,
                ]);
                break;
            case 2:
                $movil->update([
                    'operativo' => 0,
                    'operatividad_id' => 1,
                ]);
                break;
            case 4:
                $movil->update([
                    'operativo' => 0,
                    'operatividad_id' => 2,
                ]);
                break;
            case 5:
                $movil->update([
                    'compania_id' => $this->compania_id,
                ]);
                break;
        }
        MovilComentario::create([
            'movil_id' => $this->movil_id,
            'accion_id' => $this->accion_id,
            'comentario' => $this->comentario,
            'creadoPor' => Auth::id(),
        ]);
        session()->flash('success', 'Comentario Agregado Correctamente!');
        $this->redirectRoute('materiales.mayor.show', ['movil' => $this->movil_id]);
    }

    public function render()
    {
        return view('livewire.materiales.mayor.agregar-accion', [
            'companias' => Compania::select('idcompanias', 'compania')->orderBy('orden')->get()
        ]);
    }
}
