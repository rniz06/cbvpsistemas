<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Cca\Servicios\Existente;
use App\Models\Vistas\Cca\VtExistente;
use Livewire\Attributes\Validate;
use Livewire\Component;

class VerServicio extends Component
{
    public $servicio, $mostrarFormAgregarDetalle = false;

    public $km_final = null, $desperfecto = false;

    public function rules()
    {
        return [
            'km_final' => $this->desperfecto ? 'nullable' : 'required|numeric|min_digits:1|max_digits:11',
        ];
    }

    public function mount(VtExistente $servicio)
    {
        $this->servicio = $servicio;
    }

    public function guardarDetalles()
    {
        $this->validate();
        Existente::where('id_servicio_existente', $this->servicio->id_servicio_existente)->update([
            'km_final'   => $this->km_final,
            'desperfecto' => $this->desperfecto,
        ]);
        if (is_null($this->km_final)) {
            $mensaje = "10.77 Asignado Correctamente!";
        } else {
            $mensaje = "Kilometraje Final Asignado Correctamente!";
        }
        
        return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $this->servicio->id_servicio_existente])
            ->with('success', $mensaje);
    }

    // Deshabilita el input desperfecto
    public function btndesperfecto()
    {
        $this->desperfecto = !$this->desperfecto;
        if ($this->desperfecto) {
            $this->km_final = null;
        }
    }

    public function horaAccion($accion, $servicioId)
    {
        $servicio =  Existente::findOrFail($servicioId);
        switch ($accion) {
            case '1':
                $servicio->update([
                    'fecha_cia' => now(),
                ]);
                $mensaje = 'Llegada de Cia Accionada Correctamente!';
                break;

            case '2':
                $servicio->update([
                    'fecha_movil' => now(),
                ]);
                $mensaje = 'Salida de Móvil Accionada Correctamente!';
                break;

            case '3':
                $servicio->update([
                    'fecha_servicio' => now(),
                ]);
                $mensaje = 'Llegada de Móvil Accionada Correctamente!';
                break;

            case '4':
                $servicio->update([
                    'fecha_base' => now(),
                    'estado_id' => 4, // Servicio Culminado
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
