<?php

namespace App\Livewire\Materiales\EquipoHidraulico;

use App\Models\Materiales\Accion;
use App\Models\Materiales\EquipoHidraulico\Comentario;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AgregarAccion extends Component
{
    public $hidraulico_id;
    public $mostrar = false;
    public $accion_id = '';
    public $comentario = '';

    protected $listeners = ['openFormAgregarComentario' => 'open'];

    protected $rules = [
        'hidraulico_id' => ['required','exists:MAT_hidraulicos,id_hidraulico'],
        'accion_id' => ['required','exists:MAT_acciones,id_accion'],
        'comentario' => ['required', 'string', 'max:65535'],
    ];

    public function mount($hidraulico_id)
    {
        $this->hidraulico_id = $hidraulico_id;
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
        Comentario::create([
            'hidraulico_id' => $this->hidraulico_id,
            'accion_id' => $this->accion_id,
            'comentario' => $this->comentario,
            'creadoPor' => Auth::id(),
        ]);
        $this->close();
        $this->redirectRoute('materiales.hidraulicos.show', ['hidraulico' => $this->hidraulico_id]);
    }

    public function render()
    {
        return view('livewire.materiales.equipo-hidraulico.agregar-accion',[
            'acciones' => Accion::select('id_accion', 'accion')->get()
        ]);
    }
}
