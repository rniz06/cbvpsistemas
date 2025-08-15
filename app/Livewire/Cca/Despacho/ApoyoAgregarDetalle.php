<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Cca\Servicios\Apoyo;
use App\Models\Cca\Servicios\Existente;
use App\Models\Vistas\Cca\VtExistenteApoyo;
use Livewire\Component;

class ApoyoAgregarDetalle extends Component
{
    public $apoyo;

    public $km_final = null, $desperfecto = false;

    public function mount(VtExistenteApoyo $apoyo)
    {
        $this->apoyo = $apoyo;
    }

    public function rules()
    {
        return [
            'km_final' => $this->desperfecto ? 'nullable' : 'required|numeric|min_digits:1|max_digits:11',
        ];
    }

    public function guardarDetalles()
    {
        $this->validate();
        $apoyo = Apoyo::findOrFail($this->apoyo->idservicio_existente_apoyo);
        $apoyo->update([
            'km_final'   => $this->km_final,
            'desperfecto' => $this->desperfecto,
            'fecha_base'  => now(),
        ]);
        if (is_null($this->km_final)) {
            $mensaje = "10.77 Asignado Correctamente!";
        } else {
            $mensaje = "Kilometraje Final Asignado Correctamente!";
        }
        
        return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $this->apoyo->servicio_existente_id])
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

    public function render()
    {
        return view('livewire.cca.despacho.apoyo-agregar-detalle');
    }
}
