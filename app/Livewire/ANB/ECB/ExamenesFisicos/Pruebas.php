<?php

namespace App\Livewire\ANB\ECB\ExamenesFisicos;

use Livewire\Component;
use App\Models\ANB\ECB\ExamenFisico;
use App\Models\ANB\ECB\ExamenFisicoPrueba;

class Pruebas extends Component
{

    public ExamenFisico $examen;

    public $mostrarCreate=false;

    public $nombre;

    public $tipo_medicion='REPETICIONES';



    public function save()
    {

        $this->validate([

            'nombre'=>'required',

            'tipo_medicion'=>'required'

        ]);



        ExamenFisicoPrueba::create([

            'examen_fisico_id'=>$this->examen->id,

            'nombre'=>$this->nombre,

            'tipo_medicion'=>$this->tipo_medicion,

        ]);



        $this->reset(

            'nombre'

        );



        $this->tipo_medicion='REPETICIONES';

        $this->mostrarCreate=false;

    }



    public function render()
    {

        return view(

            'livewire.anb.ecb.examenes-fisicos.pruebas',

            [

                'pruebas'=>$this->examen

                    ->pruebas()

                    ->latest()

                    ->get()

            ]

        );

    }

}