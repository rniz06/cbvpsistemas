<?php

namespace App\Livewire\Materiales\EquipoHidraulico\Herramientas;

use App\Models\Materiales\Accion;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Comentario;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AgregarAccion extends Component
{
    public $herramienta_id;
    public $hidraulico_id;
    public $mostrar = false;
    public $accion_id = '';
    public $comentario = '';

    protected $listeners = ['openFormAgregarAccion' => 'open'];

    protected $rules = [
        'herramienta_id' => ['required','exists:MAT_hidraulicos_herr,id_hidraulico_herr'],
        'accion_id' => ['required','exists:MAT_acciones,id_accion'],
        'comentario' => ['required', 'string', 'max:65535'],
    ];

    public function mount($herramienta_id)
    {
        $this->herramienta_id = $herramienta_id;
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
            'herramienta_id' => $this->herramienta_id,
            'accion_id' => $this->accion_id,
            'comentario' => $this->comentario,
            'creadoPor' => Auth::id(),
        ]);
        $this->close();
        $this->redirectRoute('materiales.hidraulicos.herramientas.show', ['hidraulico' => $this->hidraulico_id, 'herramienta' => $this->herramienta_id]);
    }

    public function render()
    {
        return view('livewire.materiales.equipo-hidraulico.herramientas.agregar-accion',[
            'acciones' => Accion::select('id_accion', 'accion')->limit(3)->get()
        ]);
    }
}
