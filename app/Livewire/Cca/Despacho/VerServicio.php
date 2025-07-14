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

    public function horaAccion($accion)
    {
        switch ($accion) {
            case '1':
                $servicio = Existente::where('id_servicio_existente', $this->servicio->id_servicio_existente)->update([
                    'fecha_cia' => now(),
                ]);
                $mensaje = 'Llegada de Cia Accionada Correctamente!';
                break;

            case '2':
                $servicio = Existente::where('id_servicio_existente', $this->servicio->id_servicio_existente)->update([
                    'fecha_movil' => now(),
                ]);
                $mensaje = 'Salida de Móvil Accionada Correctamente!';
                break;

            case '3':
                $servicio = Existente::where('id_servicio_existente', $this->servicio->id_servicio_existente)->update([
                    'fecha_servicio' => now(),
                ]);
                $mensaje = 'Llegada de Móvil Accionada Correctamente!';
                break;

            case '4':
                $servicio = Existente::where('id_servicio_existente', $this->servicio->id_servicio_existente)->update([
                    'fecha_base' => now(),
                ]);
                $mensaje = 'Móvil en base Accionada Correctamente!';
                break;
        }

        return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $this->servicio->id_servicio_existente])
            ->with('success', $mensaje);
    }

    public function render()
    {
        return view('livewire.cca.despacho.ver-servicio');
    }
}
