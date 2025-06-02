<?php

namespace App\Livewire\Materiales\Mayor;

use App\Models\Materiales\Accion;
use App\Models\Materiales\Movil\MovilComentario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use Livewire\Component;

class AgregarAccion extends Component
{
    public $movil_id;
    public $mostrar = false;
    public $accion_id = '';
    public $comentario = '';

    protected $listeners = ['openFormAgregarAccion' => 'open'];

    protected $rules = [
        'movil_id' => ['required','exists:MAT_moviles,id_movil'],
        'accion_id' => ['required','exists:MAT_acciones,id_accion'],
        'comentario' => ['required', 'string', 'max:65535'],
    ];

    public function mount($movil_id)
    {
        $this->movil_id = $movil_id;
    }

    public function open()
    {
        $this->mostrar = true;
        // NO resetees movil_id porque lo necesitas
        $this->reset(['accion_id', 'comentario']);
        $this->resetValidation();
    }

    public function close()
    {
        $this->mostrar = false;
    }

    public function save()
    {
        $this->validate();
        MovilComentario::create([
            'movil_id' => $this->movil_id,
            'accion_id' => $this->accion_id,
            'comentario' => $this->comentario,
            'creadoPor' => Auth::id(),
        ]);
        $this->close();
        $this->redirectRoute('materiales.mayor.show', ['movil' => $this->movil_id]);
    }

    public function render()
    {
        return view('livewire.materiales.mayor.agregar-accion', [
            'acciones' => Accion::select('id_accion', 'accion')->get()
        ]);
    }
}