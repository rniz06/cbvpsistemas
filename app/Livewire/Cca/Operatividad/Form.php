<?php

namespace App\Livewire\Cca\Operatividad;

use App\Models\Cca\Operatividad\Operatividad;
use App\Models\Gral\Compania;
use App\Models\Personal;
use App\Models\Personal\Comisionamiento;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Form extends Component
{
    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public string $acargo;
    public int $cant_personal;
    public int $cant_conductor;
    public bool $equipo_hidraulico;
    public bool $pileta;
    public int $cant_autonomo;
    public int $cant_espuma;
    public $compania, $ult_reg_operatividad;

    public function mount(int $companiaId)
    {
        $this->compania = Compania::findOrFail($companiaId);
        $this->cargarUltRegOperatividad();
    }


    # REGLAS DE VALIDACION
    protected function rules()
    {
        return [
            'acargo'            => ['required', 'string'],
            'cant_personal'     => ['required', 'integer', 'min:0'],
            'cant_conductor'    => ['required', 'integer', 'min:0'],
            'equipo_hidraulico' => ['required', 'boolean'],
            'pileta'            => ['required', 'boolean'],
            'cant_autonomo'     => ['required', 'integer', 'min:0'],
            'cant_espuma'       => ['required', 'integer', 'min:0'],
            // 'compania_id'       => ['required', 'integer', 'exists:companias,id'],
        ];
    }

    # FUNCION PARA GUARDAR UN NUEVO REGISTRO
    public function guardar()
    {
        $this->validate();

        try {
            $datosAcargo = $this->calcularAcargo();
            Operatividad::create([
                'fecha_hora'         => now(),
                'acargo'             => $datosAcargo['acargo'],
                'acargo_aux'         => $datosAcargo['acargo_aux'],
                'cant_personal'      => $this->cant_personal,
                'cant_conductor'     => $this->cant_conductor,
                'equipo_hidraulico'  => $this->equipo_hidraulico,
                'pileta'             => $this->pileta,
                'cant_autonomo'      => $this->cant_autonomo,
                'cant_espuma'        => $this->cant_espuma,
                'compania_id'        => $this->compania->id_compania,
                'creadoPor'          => Auth::id(),
            ]);
            session()->flash('success', 'REGISTRADO CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO REGISTRAR-' . $e->getMessage());
        }

        $this->redirectRoute('cca.operatividad.index');
    }

    public function render()
    {
        return view('livewire.cca.operatividad.form');
    }

    # FUNCION QUE ESCUCHA BTN CERRAR DEL MODAL Y RESETEA LOS CAMPOS
    public function resetForm()
    {
        $this->reset([
            'acargo',
            'cant_personal',
            'cant_conductor',
            'equipo_hidraulico',
            'pileta',
            'cant_autonomo',
            'cant_espuma',
            'compania',
        ]);

        $this->resetValidation();
    }

    # FUNCION QUE CARGA EL ULTIMO REGISTRO DE OPERATIVIDAD
    public function cargarUltRegOperatividad()
    {
        $this->ult_reg_operatividad = Operatividad::where('compania_id', $this->compania->id_compania)
            ->latest()
            ->first();

        if ($this->ult_reg_operatividad) {

            $this->acargo = $this->getAcargoLabel();
            $this->cant_personal     = $this->ult_reg_operatividad->cant_personal ?? 0;
            $this->cant_conductor    = $this->ult_reg_operatividad->cant_conductor ?? 0;
            $this->equipo_hidraulico = (bool) ($this->ult_reg_operatividad->equipo_hidraulico ?? false);
            $this->pileta            = (bool) ($this->ult_reg_operatividad->pileta ?? false);
            $this->cant_autonomo     = $this->ult_reg_operatividad->cant_autonomo ?? 0;
            $this->cant_espuma       = $this->ult_reg_operatividad->cant_espuma ?? 0;
        }
    }

    public function getAcargoLabel(): string
    {
        # SI NO SE REGISTRA OPERATIVIDAD RETORNAR CAMPO VACIO
        if (!$this->ult_reg_operatividad) {
            return '';
        }
        #PRIORIZA LA CARGA DEL CAMPO acargo_aux, SI NO ESTA CARGADO RETORNA EL CODIGO DE VOLUNTARIO
        return $this->ult_reg_operatividad->acargo_aux
            ?: ($this->ult_reg_operatividad->acargoRel?->codigo ?? '');
    }

    public function calcularAcargo(): array
    {
        $valor = trim((string) $this->acargo);

        if ($valor === '') {
            return [
                'acargo' => null,
                'acargo_aux' => null,
            ];
        }

        // Código numérico: buscar directamente en Personal
        if (ctype_digit($valor)) {
            $idPersonal = Personal::where('codigo', $valor)
                ->value('idpersonal');

            return [
                'acargo' => $idPersonal,
                'acargo_aux' => $idPersonal ? null : $valor,
            ];
        }

        // Código de comisionamiento: buscar solamente los activos
        $idPersonal = Comisionamiento::query()
            ->where('codigo_comisionamiento', $valor)
            ->where('culminado', false)
            ->value('personal_id');

        return [
            'acargo' => $idPersonal,
            'acargo_aux' => $valor,
        ];
    }
}
