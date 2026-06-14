<?php

namespace App\Livewire\ANB\ECB\PsicoTests;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ANB\ECB\PsicoPregunta;
use App\Models\ANB\ECB\PsicoOpcion;

class Opciones extends Component
{

    use WithFileUploads;

    public PsicoPregunta $pregunta;

    public $mostrarCreate=false;

    public $texto;

    public $imagen;

    public $correcta=false;

    public $valor;



    public function save()
    {

        $ruta=null;

        if($this->imagen){

            $ruta=

                $this->imagen->store(

                    'psico/opciones',

                    'public'

                );

        }



        PsicoOpcion::create([

            'pregunta_id'=>

                $this->pregunta->id,

            'texto'=>$this->texto,

            'imagen'=>$ruta,

            'correcta'=>$this->correcta,

            'valor'=>$this->valor

        ]);



        $this->reset(

            'texto',

            'imagen',

            'correcta',

            'valor'

        );



        $this->mostrarCreate=false;

    }



    public function render()
    {

        return view(

            'livewire.anb.ecb.psico-tests.opciones',

            [

                'opciones'=>

                $this->pregunta

                ->opciones()

                ->get()

            ]

        );

    }

}