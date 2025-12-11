<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Personal\Asistencia\Detalle;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Carga2 extends Component
{
  # REGISTRO ACTUAL
  public $detalle;

  # CAMPOS DEL FORMULARIO
  #[Validate]
  public $practica, $guardia, $citacion;

  public $bloqueoCitacion = true;

  public function mount($detalle)
  {
    $this->detalle = Detalle::with(['asistencia:id_asistencia,hubo_citacion', 'personal:idpersonal,nombrecompleto,codigo'])->findOrFail($detalle);

    $this->practica = $this->detalle->practica;
    $this->guardia  = $this->detalle->guardia;
    $this->citacion = $this->detalle->citacion;
  }

  protected function rules()
  {
    return [
      'practica' => ['required', 'integer', 'min_digits:1', 'max_digits:3', 'min:0', 'max:100'],
      'guardia'  => ['required', 'integer', 'min_digits:1', 'max_digits:3', 'min:0', 'max:100'],
      'citacion' => [
        'nullable',
        'integer',
        'min_digits:1',
        'max_digits:3',
        'min:0',
        'max:100',
        Rule::requiredIf($this->detalle->asistencia->hubo_citacion == true)
      ]
    ];
  }

  public function guardar()
  {
    $this->validate();

    try {
      $this->detalle->update([
        'practica' => $this->practica,
        'guardia'  => $this->guardia,
        'citacion' => $this->citacion,
        'total'    => $this->calcularPromedio()
      ]);
      session()->flash('success', 'ASISTENCIA REGISTRADA CORRECTAMENTE!');
    } catch (\Exception $e) {
      session()->flash('error', 'NO SE PUDO REGISTRAR LA ASISTENCIAS' . $e->getMessage());
    }

    # EMITE EVENTO QUE ESCUCHA EL COMPONENTE PRINCIPAL PARA REFRESCAR LOS DATOS SIN REFRESCAR LA PAGINA
    $this->dispatch('asistencia-cargada');
  }

  private function calcularPromedio()
  {
    // SI NO HAY CITACION PROMEDIAR POR PRACTICA Y GUARDIA
    if ($this->detalle->asistencia->hubo_citacion == true) {
      return ($this->practica + $this->guardia + $this->citacion) / 3;
    }

    if ($this->detalle->asistencia->hubo_citacion == false) {
      return ($this->practica + $this->guardia) / 2;
    }
    return;
  }

  public function render()
  {
    return view('livewire.personal.asistencias.carga2');
  }
}
