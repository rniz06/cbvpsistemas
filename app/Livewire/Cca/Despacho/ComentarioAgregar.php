<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Cca\Servicios\Comentario;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ComentarioAgregar extends Component
{
    // Propiedad recibida desde la ruta
    public $servicio;

    // Propiedad del formulario
    #[Validate('required|min:3|max:65535|string')]
    public $comentario;

    public function guardar()
    {
        $this->validate();
        Comentario::create([
            'comentario' => $this->comentario,
            'servicio_id' => $this->servicio,
            'creadoPor' => Auth::id(),
        ]);
        // session()->flash('success', 'Comentario Agregado Correctamente!');
        // $this->redirectRoute('cca.despacho.ver-servicio', ['servicio' => $this->servicio]);
        $this->dispatch('comentario-agregado');
        $this->dispatch('cerrar-formulario-comentario');
        $this->reset('comentario');
    }
    
    public function render()
    {
        return view('livewire.cca.despacho.comentario-agregar');
    }
}
