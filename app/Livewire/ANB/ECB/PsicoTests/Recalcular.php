<?php

namespace App\Livewire\ANB\ECB\PsicoTests;

use Livewire\Component;
use App\Models\ANB\ECB\PsicoSesion;
use App\Services\Psicologia\PsicoMotorService;
use App\Models\ANB\ECB\PsicoRespuesta;

class Recalcular extends Component
{
    public $procesados=0;
    public $pendientes = [];


    public function cargarPendientes()
{
    $this->pendientes =

        PsicoSesion::with(

            'test',

            'aspirante',

            'respuestas',

            'resultados'

        )

        ->where(

            'finalizado',

            true

        )

        ->get()

        ->filter(function($sesion){

            if(

                $sesion->test->codigo=='WONDERLIC'

            ){

                return is_null(

                    $sesion->puntaje

                );

            }

            return

                $sesion->resultados->count()==0;

        })

        ->values();
}

public function recalcular()
{
    $this->procesados = 0;

    $sesiones =

        PsicoSesion::with(

            'test',

            'aspirante',

            'resultados'

        )

        ->where(

            'finalizado',

            true

        )

        ->get();

    foreach($sesiones as $sesion){

        /*
        |--------------------------------------------------------------------------
        | Wonderlic
        |--------------------------------------------------------------------------
        */

        if($sesion->test->codigo=='WONDERLIC'){

            if(!is_null($sesion->puntaje)){
                continue;
            }

            $puntaje =

                PsicoRespuesta::where(

                    'sesion_id',

                    $sesion->id

                )

                ->whereHas(

                    'opcion',

                    function($q){

                        $q->where(

                            'correcta',

                            true

                        );

                    }

                )

                ->count();

            $sesion->update([

                'puntaje'=>$puntaje

            ]);

            $this->procesados++;

            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | NEOFFI y LSB50
        |--------------------------------------------------------------------------
        */

        if(

            in_array(

                $sesion->test->codigo,

                [

                    'NEOFFI',

                    'LSB50-ORIGINAL'

                ]

            )

        ){

            if($sesion->resultados->count()>0){
                continue;
            }

            app(

                \App\Services\Psicologia\PsicoMotorService::class

            )->corregir(

                $sesion

            );

            $this->procesados++;

        }

    }

    session()->flash(

        'success',

        'Se recalcularon correctamente '.$this->procesados.' evaluaciones psicológicas.'

    );
}

    public function render()
    {
        return view(

            'livewire.anb.ecb.psico-tests.recalcular'

        );
    }
}