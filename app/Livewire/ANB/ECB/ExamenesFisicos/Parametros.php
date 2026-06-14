<?php

namespace App\Livewire\ANB\ECB\ExamenesFisicos;

use Livewire\Component;
use App\Models\ANB\ECB\ExamenFisicoPrueba;
use App\Models\ANB\ECB\ExamenFisicoParametro;

class Parametros extends Component
{

    public ExamenFisicoPrueba $prueba;

    public $mostrarCreate=false;

    public $sexo='M';

    public $valor_min;

    public $valor_max;

    public $puntaje;



    public function save()
    {

        $this->validate([

            'sexo'=>'required',

            'valor_min'=>'required|numeric',

            'valor_max'=>'required|numeric',

            'puntaje'=>'required|numeric'

        ]);



        ExamenFisicoParametro::create([

            'prueba_id'=>$this->prueba->id,

            'sexo'=>$this->sexo,

            'valor_min'=>$this->valor_min,

            'valor_max'=>$this->valor_max,

            'puntaje'=>$this->puntaje,

        ]);



        $this->reset(

            'valor_min',

            'valor_max',

            'puntaje'

        );



        $this->sexo='M';

        $this->mostrarCreate=false;

    }



    public function render()
    {

        return view(

            'livewire.anb.ecb.examenes-fisicos.parametros',

            [

                'parametros'=>$this->prueba

                    ->parametros()

                    ->orderBy('sexo')

                    ->orderByDesc('puntaje')

                    ->get()

            ]

        );

    }

}