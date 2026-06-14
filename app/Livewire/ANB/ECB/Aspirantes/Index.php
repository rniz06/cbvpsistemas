<?php

namespace App\Livewire\ANB\ECB\Aspirantes;

use Livewire\Component;
use App\Models\ANB\ECB\Llamado;
use App\Models\Gral\Compania;
use App\Models\ANB\ECB\Aspirante;

class Index extends Component
{

    public $buscar='';

    public $mostrarCreate=false;

    public $filtro_llamado='';

    public $filtro_compania='';

    public $filtro_estado='';

    public $llamado_id;

    public $compania_id;

    public $nombre;

    public $apellido;

    public $cedula;

    public $celular;

    public $correo;

    public $ciudad;

    public $fecha_nacimiento;

    public $estado='PRE_ASPIRANTE';

    public $sexo;

    public function save()
    {

        $this->validate([

            'llamado_id'=>'required',

            'compania_id'=>'required',

            'nombre'=>'required',

            'apellido'=>'required',

            'cedula'=>'required',

            'celular'=>'required',

            'ciudad'=>'required',

            'fecha_nacimiento'=>'required',

            'estado'=>'required',

            'sexo'=>'required',

        ]);

        Aspirante::create([

            'llamado_id'=>$this->llamado_id,

            'compania_id'=>$this->compania_id,

            'nombre'=>$this->nombre,

            'apellido'=>$this->apellido,

            'cedula'=>$this->cedula,

            'celular'=>$this->celular,

            'correo'=>$this->correo,

            'ciudad'=>$this->ciudad,

            'fecha_nacimiento'=>$this->fecha_nacimiento,

            'estado'=>$this->estado,
            'sexo'=>$this->sexo,

        ]);

        $this->reset([

            'llamado_id',

            'compania_id',

            'nombre',

            'apellido',

            'cedula',

            'celular',

            'correo',

            'ciudad',

            'fecha_nacimiento',
            'sexo',

        ]);

        $this->estado='PRE_ASPIRANTE';

        $this->mostrarCreate=false;

    }



    public function render()
    {

        $query=Aspirante::query()

            ->with([

                'llamado',

                'compania'

            ]);



        if($this->buscar){

            $query->where(function($q){

                $q->where(

                    'nombre',

                    'like',

                    '%'.$this->buscar.'%'

                )

                ->orWhere(

                    'apellido',

                    'like',

                    '%'.$this->buscar.'%'

                )

                ->orWhere(

                    'cedula',

                    'like',

                    '%'.$this->buscar.'%'

                );

            });

        }



        if($this->filtro_llamado){

            $query->where(

                'llamado_id',

                $this->filtro_llamado

            );

        }



        if($this->filtro_compania){

            $query->where(

                'compania_id',

                $this->filtro_compania

            );

        }



        if($this->filtro_estado){

            $query->where(

                'estado',

                $this->filtro_estado

            );

        }



        return view(

            'livewire.anb.ecb.aspirantes.index',

            [

                'aspirantes'=>$query

                    ->latest()

                    ->get(),

                'llamados'=>Llamado::all(),

                'companias'=>Compania::all(),

            ]

        );

    }

}