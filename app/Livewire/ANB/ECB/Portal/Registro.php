<?php

namespace App\Livewire\ANB\ECB\Portal;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\ANB\ECB\Aspirante;
use App\Models\ANB\ECB\Llamado;
use App\Models\Gral\Compania;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Registro extends Component
{
    use WithFileUploads;
    public $aceptaDeclaracion = false;
    public $paso = 1;
    public $registroExistente = false;
    public $nombre;

    public $apellido;

    public $cedula;

    public $fecha_nacimiento;

    public $sexo;

    public $celular;

    public $correo;

    public $ciudad;

    public $compania_id;

    public $llamado_id;

    public $cedula_frente;

    public $cedula_atras;


    public function rendering($view)
    {
        $view->layout('layouts.portalpublico');
    }


    public function mount()
    {
        $this->llamado_id=

            optional(

                Llamado::where(

                    'activo',

                    true

                )->first()

            )->id;
    }

    public function continuar()
    {

        $this->validate([

            
            'llamado_id'=>'required',

            'cedula'=>'required'

        ]);



        $this->registroExistente=false;



        $aspirante=

            Aspirante::where(

                'cedula',

                $this->cedula

            )

            ->first();



        if($aspirante){

            $this->registroExistente=true;

            $this->nombre=$aspirante->nombre;

            $this->apellido=$aspirante->apellido;

            $this->fecha_nacimiento=$aspirante->fecha_nacimiento;

            $this->sexo=$aspirante->sexo;

            $this->correo=$aspirante->correo;

            $this->celular=$aspirante->celular;

            $this->ciudad=$aspirante->ciudad;

            $this->compania_id=$aspirante->compania_id;

        }



        $this->paso=2;

    }

    public function updatedCedula()
    {
        $this->registroExistente = false;

        if(empty($this->cedula)){
            return;
        }

        $aspirante = Aspirante::where(

            'cedula',

            $this->cedula

        )->first();

        if(!$aspirante){
            return;
        }

        $this->registroExistente = true;

        $this->nombre = $aspirante->nombre;
        $this->apellido = $aspirante->apellido;
        $this->fecha_nacimiento = $aspirante->fecha_nacimiento;
        $this->sexo = $aspirante->sexo;
        $this->celular = $aspirante->celular;
        $this->correo = $aspirante->correo;
        $this->ciudad = $aspirante->ciudad;
        $this->compania_id = $aspirante->compania_id;
        $this->llamado_id = $aspirante->llamado_id;
    }

    public function render()
    {
        return view(

            'livewire.anb.ecb.portal.registro',

            [
            'companias' =>

                Compania::with('ciudad')

                    ->where(function ($q) {

                        $q->whereBetween(

                            'orden',

                            [1, 200]

                        )

                        ->orWhereBetween(

                            'orden',

                            [401, 490]

                        );

                    })

                    ->orderBy(

                        'orden'

                    )

                    ->get(),

                'llamados'=>

                    Llamado::where(

                        'activo',

                        true

                    )->get()

            ]

        );
    }



    public function save()
{
    $this->validate([

        'aceptaDeclaracion' => 'accepted',
        
        'llamado_id' => 'required',

        'nombre' => 'required',

        'apellido' => 'required',

        'cedula' => 'required',

        'fecha_nacimiento' => 'required',

        'sexo' => 'required',

        'celular' => 'required',

        'correo' => 'nullable|email',

        'ciudad' => 'required',

        'compania_id' => 'required',

        'cedula_frente' => 'required|image|max:5120',

        'cedula_atras' => 'required|image|max:5120',

    ]);



    $aspirante =

        Aspirante::where(

            'cedula',

            $this->cedula

        )->first();



    if(!$aspirante){

        $aspirante = new Aspirante();

        $aspirante->estado = 'PRE_ASPIRANTE';

    }



    $aspirante->llamado_id = $this->llamado_id;

    $aspirante->nombre = Str::upper($this->nombre);

    $aspirante->apellido = Str::upper($this->apellido);

    $aspirante->cedula = $this->cedula;

    $aspirante->fecha_nacimiento = $this->fecha_nacimiento;

    $aspirante->sexo = $this->sexo;

    $aspirante->celular = $this->celular;

    $aspirante->correo = $this->correo;

    $aspirante->ciudad = Str::upper($this->ciudad);

    $aspirante->compania_id = $this->compania_id;

    $aspirante->origen = 'PORTAL';

    $aspirante->fecha_postulacion = now();



    /*
    |--------------------------------------------------------------------------
    | CÉDULA FRENTE
    |--------------------------------------------------------------------------
    */

    if($this->cedula_frente){

        if($aspirante->cedula_frente){

            Storage::disk('public')->delete(

                $aspirante->cedula_frente

            );

        }

        $extension =

            $this->cedula_frente

                ->getClientOriginalExtension();



        $nombre =

            $this->cedula

            .'.frente.'

            .$extension;



        $this->cedula_frente->storeAs(

            'ecb/cedulas',

            $nombre,

            'public'

        );



        $aspirante->cedula_frente =

            'ecb/cedulas/'.$nombre;

    }



    /*
    |--------------------------------------------------------------------------
    | CÉDULA ATRÁS
    |--------------------------------------------------------------------------
    */

    if($this->cedula_atras){

        if($aspirante->cedula_atras){

            Storage::disk('public')->delete(

                $aspirante->cedula_atras

            );

        }

        $extension =

            $this->cedula_atras

                ->getClientOriginalExtension();



        $nombre =

            $this->cedula

            .'.atras.'

            .$extension;



        $this->cedula_atras->storeAs(

            'ecb/cedulas',

            $nombre,

            'public'

        );



        $aspirante->cedula_atras =

            'ecb/cedulas/'.$nombre;

    }



    $aspirante->save();



    session()->flash(

    'success',

    'Su postulación fue registrada correctamente.'

);

/*
|--------------------------------------------------------------------------
| Reiniciar Portal
|--------------------------------------------------------------------------
*/

$this->reset(

    'nombre',

    'apellido',

    'cedula',

    'fecha_nacimiento',

    'sexo',

    'celular',

    'correo',

    'ciudad',

    'compania_id',

    'cedula_frente',

    'cedula_atras',

    'aceptaDeclaracion'

);

$this->registroExistente = false;

$this->paso = 1;

$this->resetValidation();

$this->llamado_id = optional(

    Llamado::where(

        'activo',

        true

    )->first()

)->id;
}
}