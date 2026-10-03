<?php

namespace App\Livewire\ANB\ECB\PsicoTests;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ANB\ECB\PsicoTest;
use App\Models\ANB\ECB\PsicoPregunta;

class Preguntas extends Component
{

    use WithFileUploads;

    public PsicoTest $test;

    public $mostrarCreate=false;

    public $orden;

    public $pregunta;
    public $dimension_id;


    public $imagen;



    public function save()
    {
    
        $this->validate([

            'orden'=>'required',

            'pregunta'=>'required'

        ]);



        $ruta=null;



        if($this->imagen){

            $ruta=

                $this->imagen->store(

                    'psico/preguntas',

                    'public'

                );

        }



        PsicoPregunta::create([

            'test_id'=>$this->test->id,

            'orden'=>$this->orden,

            'pregunta'=>$this->pregunta,

            'dimension_id'=>$this->dimension_id,

            'imagen'=>$ruta

        ]);



        $this->reset(

            'orden',

            'pregunta',

            'dimension_id',

            'imagen'

        );



        $this->mostrarCreate=false;

    }



    public function render()
    {

        return view(
            'livewire.anb.ecb.psico-tests.preguntas',
            [
                'preguntas'=>
                    $this->test
                        ->preguntas()
                        ->with('dimension')
                        ->orderBy('orden')
                        ->get(),
                'dimensiones'=>
                    $this->test
                        ->dimensiones()
                        ->orderBy('nombre')
                        ->get()
            ]
        );

    }

}