<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Gral\Compania;
use App\Models\Personal;
use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Detalle;
use App\Models\Personal\Asistencia\Estado;
use App\Models\Personal\Asistencia\Periodo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class GenerarManualmente extends Component
{
    # CAMPOS DEL FORMULARIO
    #[Validate]
    public $compania_id, $periodo_id, $estado_id;

    # PROPIEDADES PARA LOS SELECT
    public $companias = [], $periodos = [], $estados = [];

    #FUNCION MOUNT DE LIVEWIRE
    public function mount()
    {
        $this->companias = Compania::orderBy('orden')->get(['id_compania', 'compania']);
        $this->periodos  = Periodo::with(['mes:id_mes,mes', 'anho:id_anho,anho'])->get();
        $this->estados   = Estado::get('id_asistencia_estado', 'estado');
    }

    protected function rules()
    {
        return [
            'compania_id' => ['required', 'integer', Rule::exists(Compania::class, 'id_compania')],
            'periodo_id'  => [
                'required',
                'integer',
                Rule::exists(Periodo::class, 'id_asistencia_periodo'),
                Rule::unique(Asistencia::class)->where('compania_id', $this->compania_id)->whereNull('deleted_at')
            ],
            'estado_id'   => ['required', 'integer', Rule::exists(Estado::class, 'id_asistencia_estado')]
        ];
    }

    protected function messages()
    {
        return [
            'periodo_id.unique' => 'YA EXISTE UN PERIODO PARA ESTA COMPAÑIA.',
        ];
    }

    public function guardar()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                # GENERAR CABECERA
                $asistencia = Asistencia::create(['compania_id' => $this->compania_id, 'periodo_id' => $this->periodo_id, 'estado_id' => $this->estado_id]);

                # OBTENER LOS VOLUNTARIOS DE TAL COMPANIA
                $personales = Personal::where('compania_id', $this->compania_id)->get(['idpersonal', 'estado_id']);

                # GENERAR LOS DETALLES
                foreach ($personales as $personal) {

                    if ($personal->estado_id == 11) {   # ESTADO_ID == 11(FALLECIO EN SERVICIO(MARTIR) CON 100%)
                        Detalle::create([
                            'asistencia_id' => $asistencia->id_asistencia,
                            'personal_id'   => $personal->idpersonal,
                            'practica'      => 100,
                            'guardia'       => 100,
                            'citacion'      => 100,
                            'total'         => 100
                        ]);
                    } else {
                        Detalle::create([
                            'asistencia_id' => $asistencia->id_asistencia,
                            'personal_id'   => $personal->idpersonal,
                            'practica'      => 0,
                            'guardia'       => 0,
                            'citacion'      => null,
                            'total'         => 0
                        ]);
                    }
                }
            });

            session()->flash('success', 'PERIODO DE ASISTENCIA GENERADO CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO GENERAR EL PERIODO DE ASISTENCIA ' . $e->getMessage());
        }

        $this->redirectRoute('personal.asistencias.generar-manualmente');
    }

    public function render()
    {
        return view('livewire.personal.asistencias.generar-manualmente');
    }
}
