<?php

namespace App\Livewire\ANB\ECB\PsicoTests;

use Livewire\Component;
use App\Models\ANB\ECB\PsicoTest;
use App\Models\ANB\ECB\PsicoDimension;

class Index extends Component
{

    public $buscar='';

    public $mostrarCreate=false;

    public $nombre;

    public $codigo;

    public $descripcion;

    public $duracion_minutos;

    public $activo=true;



    public function save()
    {

        $this->validate([

            'nombre'=>'required',

            'codigo'=>'required'

        ]);



        $test = PsicoTest::create([
            'nombre'=>$this->nombre,
            'codigo'=>strtoupper($this->codigo),
            'descripcion'=>$this->descripcion,
            'duracion_minutos'=>$this->duracion_minutos,
            'activo'=>$this->activo
        ]);

        switch($test->codigo){
            case 'NEOFFI':
                foreach([
                    'Neuroticismo',
                    'Extraversión',
                    'Apertura',
                    'Amabilidad',
                    'Responsabilidad'
                ] as $dimension){
                    PsicoDimension::create([
                        'test_id'=>$test->id,
                        'nombre'=>$dimension
                    ]);
                }
            break;
            case 'LSB50':
                foreach([
                    'Ansiedad',
                    'Depresión',
                    'Hostilidad',
                    'Somatización',
                    'Sensibilidad Interpersonal',
                    'Alteraciones del Sueño'
                ] as $dimension){
                    PsicoDimension::create([
                        'test_id'=>$test->id,
                        'nombre'=>$dimension
                    ]);
                }
            break;

        }


        $this->reset(

            'nombre',

            'codigo',

            'descripcion',

            'duracion_minutos'

        );



        $this->activo=true;

        $this->mostrarCreate=false;

    }



    public function render()
    {

        $query=PsicoTest::query();



        if($this->buscar){

            $query->where(

                'nombre',

                'like',

                '%'.$this->buscar.'%'

            );

        }



        $tests=

            $query

            ->latest()

            ->get();



        return view(

            'livewire.anb.ecb.psico-tests.index',

            compact(
                'tests'
            )

        );

    }

}