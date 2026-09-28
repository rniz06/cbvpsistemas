<?php

namespace App\Livewire\Cca\Operatividad;

use App\Models\Cca\Operatividad\Operatividad;
use App\Models\Cca\Operatividad\OperatividadMovil;
use App\Models\Gral\Compania;
use App\Models\Materiales\Movil\Movil;
use App\Models\Personal;
use App\Models\Personal\Comisionamiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Form extends Component
{
    /*
    |--------------------------------------------------------------------------
    | PROPIEDADES DEL FORMULARIO
    |--------------------------------------------------------------------------
    */

    #[Validate]
    public string $acargo = '';
    public int $cant_personal = 0;
    public int $cant_conductor = 0;
    public bool $equipo_hidraulico = false;
    public bool $pileta = false;
    public int $cant_autonomo = 0;
    public int $cant_espuma = 0;
    public bool $cca_operativo = false;
    public array $moviles = [];
    public $movilesSelect = [];
    public $compania;
    public $ult_reg_operatividad;


    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */

    public function mount(int $companiaId)
    {
        $this->compania = Compania::findOrFail($companiaId);

        $this->movilesSelect = Movil::filtrarOperaInope()
            ->with('acronimo:id_movil_tipo,tipo')
            ->where(
                'compania_id',
                $this->compania->id_compania
            )
            ->get([
                'id_movil',
                'movil',
                'movil_tipo_id'
            ]);

        /*
        |--------------------------------------------------------------------------
        | CARGAR ÚLTIMA OPERATIVIDAD
        |--------------------------------------------------------------------------
        */

        $this->cargarUltRegOperatividad();

        /*
        |--------------------------------------------------------------------------
        | CARGAR ESTADO ACTUAL DE LA COMPAÑÍA
        |--------------------------------------------------------------------------
        */

        $this->cca_operativo = (bool) $this->compania->cca_operativo;
    }


    /*
    |--------------------------------------------------------------------------
    | REGLAS DE VALIDACIÓN
    |--------------------------------------------------------------------------
    */

    protected function rules()
    {
        return [

            'cca_operativo' => [
                'required',
                'boolean',
            ],

            'acargo' => [
                'nullable',
                'string',
            ],

            'cant_personal' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'cant_conductor' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'equipo_hidraulico' => [
                'nullable',
                'boolean',
            ],

            'pileta' => [
                'nullable',
                'boolean',
            ],

            'cant_autonomo' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'cant_espuma' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'moviles' => [
                'nullable',
                'array',
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR
    |--------------------------------------------------------------------------
    */

    public function guardar()
    {
        $this->validate();

        try {

            $datosAcargo = $this->calcularAcargo();

            DB::transaction(function () use ($datosAcargo) {

                /*
                |--------------------------------------------------------------------------
                | ACTUALIZAR ESTADO DE LA COMPAÑÍA
                |--------------------------------------------------------------------------
                */

                $this->compania->update([
                    'cca_operativo' => $this->cca_operativo,
                ]);


                /*
                |--------------------------------------------------------------------------
                | CREAR REGISTRO DE OPERATIVIDAD
                |--------------------------------------------------------------------------
                */

                $operatividad = Operatividad::create([

                    'fecha_hora' => now(),

                    'acargo' => $datosAcargo['acargo'],

                    'acargo_aux' => $datosAcargo['acargo_aux'],

                    'cant_personal' => $this->cant_personal,

                    'cant_conductor' => $this->cant_conductor,

                    'equipo_hidraulico' => $this->equipo_hidraulico,

                    'pileta' => $this->pileta,

                    'cant_autonomo' => $this->cant_autonomo,

                    'cant_espuma' => $this->cant_espuma,

                    'compania_id' => $this->compania->id_compania,

                    'creadoPor' => Auth::id(),

                ]);


                /*
                |--------------------------------------------------------------------------
                | REGISTRAR ESTADO DE LOS MÓVILES
                |--------------------------------------------------------------------------
                */

                foreach ($this->movilesSelect as $movil) {

                    $esOperativo = in_array(
                        (string) $movil->id_movil,
                        array_map('strval', $this->moviles),
                        true
                    );

                    OperatividadMovil::create([

                        'operatividad_detalle_id' =>
                            $operatividad->id_operatividad_detalle,

                        'movil_id' =>
                            $movil->id_movil,

                        'operativo' =>
                            $esOperativo,

                        'creadoPor' =>
                            Auth::id(),

                    ]);
                }
            });

            session()->flash(
                'success',
                'REGISTRADO CORRECTAMENTE!'
            );

            $this->redirectRoute(
                'cca.operatividad.index'
            );

        } catch (\Exception $e) {

            session()->flash(
                'error',
                'NO SE PUDO REGISTRAR - ' . $e->getMessage()
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CARGAR ÚLTIMO REGISTRO DE OPERATIVIDAD
    |--------------------------------------------------------------------------
    */

    public function cargarUltRegOperatividad()
    {
        $this->ult_reg_operatividad = Operatividad::where(
            'compania_id',
            $this->compania->id_compania
        )
            ->with(['acargo_rel'])
            ->latest()
            ->first();

        if ($this->ult_reg_operatividad) {

            $this->acargo = $this->getAcargoLabel();

            $this->cant_personal =
                $this->ult_reg_operatividad->cant_personal ?? 0;

            $this->cant_conductor =
                $this->ult_reg_operatividad->cant_conductor ?? 0;

            $this->equipo_hidraulico =
                (bool) ($this->ult_reg_operatividad->equipo_hidraulico ?? false);

            $this->pileta =
                (bool) ($this->ult_reg_operatividad->pileta ?? false);

            $this->cant_autonomo =
                $this->ult_reg_operatividad->cant_autonomo ?? 0;

            $this->cant_espuma =
                $this->ult_reg_operatividad->cant_espuma ?? 0;

            $this->moviles = OperatividadMovil::where([
                [
                    'operatividad_detalle_id',
                    $this->ult_reg_operatividad->id_operatividad_detalle
                ],
                [
                    'operativo',
                    true
                ]
            ])
                ->pluck('movil_id')
                ->map(fn ($id) => (string) $id)
                ->toArray();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | OBTENER TEXTO DEL A CARGO
    |--------------------------------------------------------------------------
    */

    public function getAcargoLabel(): string
    {
        if (!$this->ult_reg_operatividad) {
            return '';
        }

        return $this->ult_reg_operatividad->acargo_aux
            ?: ($this->ult_reg_operatividad->acargo_rel?->codigo ?? '');
    }


    /*
    |--------------------------------------------------------------------------
    | CALCULAR A CARGO
    |--------------------------------------------------------------------------
    */

    public function calcularAcargo(): array
    {
        $valor = trim((string) $this->acargo);

        if ($valor === '') {

            return [
                'acargo' => null,
                'acargo_aux' => null,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | CÓDIGO NUMÉRICO
        |--------------------------------------------------------------------------
        */

        if (ctype_digit($valor)) {

            $idPersonal = Personal::where(
                'codigo',
                $valor
            )->value('idpersonal');

            return [

                'acargo' =>
                    $idPersonal,

                'acargo_aux' =>
                    $idPersonal ? null : $valor,

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | CÓDIGO DE COMISIONAMIENTO
        |--------------------------------------------------------------------------
        */

        $idPersonal = Comisionamiento::query()
            ->where(
                'codigo_comisionamiento',
                $valor
            )
            ->where(
                'culminado',
                false
            )
            ->value('personal_id');

        return [

            'acargo' =>
                $idPersonal,

            'acargo_aux' =>
                $valor,

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | RESET FORM
    |--------------------------------------------------------------------------
    */

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
            'moviles',
        ]);

        /*
        |--------------------------------------------------------------------------
        | IMPORTANTE:
        | Restaurar el estado real de la compañía.
        |--------------------------------------------------------------------------
        */

        $this->cca_operativo =
            (bool) $this->compania->cca_operativo;

        $this->resetValidation();
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view(
            'livewire.cca.operatividad.form'
        );
    }
}