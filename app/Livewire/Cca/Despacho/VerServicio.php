<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Cca\Servicios\Existente;
use App\Models\Vistas\Cca\VtExistente;
use Livewire\Component;

class VerServicio extends Component
{
    public $servicio;

    public function mount(VtExistente $servicio)
    {
        $this->servicio = $servicio;
    }

    public function fechaServicio()
    {
        $servicio = Existente::where('id_servicio_existente', $this->servicio->id_servicio_existente)->update([
            'fecha_servicio' => now(),
        ]);

        return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $this->servicio->id_servicio_existente])
            ->with('success', 'Llegada de Movil Accionada Correctamente!');
    }

    public function fechaBase()
    {
        $servicio = Existente::where('id_servicio_existente', $this->servicio->id_servicio_existente)->update([
            'fecha_base' => now(),
        ]);

        return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $this->servicio->id_servicio_existente])
            ->with('success', 'Móvil en base!');
    }

    public function render()
    {
        return view('livewire.cca.despacho.ver-servicio');
    }
}
