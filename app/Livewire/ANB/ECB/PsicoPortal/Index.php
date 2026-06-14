<?php

namespace App\Livewire\ANB\ECB\PsicoPortal;

use Livewire\Component;
use App\Models\ANB\ECB\Aspirante;
use App\Models\ANB\ECB\PsicoTest;
use App\Models\ANB\ECB\PsicoSesion;
use App\Models\ANB\ECB\PsicoPregunta;
use App\Models\ANB\ECB\PsicoRespuesta;
use App\Models\ANB\ECB\PsicoResultado;


class Index extends Component
{

    public $cedula;

    public $fecha_nacimiento;

    public $aspirante=null;

    public $testActual=null;

    public $sesionExamen=null;
    public $segundosRestantes=null;
    public $preguntaActual=0;
    public $respuestaSeleccionada=null;


    public function mount()
    {

        if(

            session()->has(
                'psico_aspirante'
            )

        ){

            $this->aspirante=

                Aspirante::find(

                    session(
                        'psico_aspirante'
                    )

                );

        }



        if(

            session()->has(
                'psico_sesion'
            )

        ){

            $this->sesionExamen=

                PsicoSesion::with(
                    'test'
                )
                ->find(

                    session(
                        'psico_sesion'
                    )

                );



            if($this->sesionExamen){
                $this->testActual=$this->sesionExamen->test;
                
            }

        }

    }



    public function validar()
    {

        $this->validate([

            'cedula'=>'required',

            'fecha_nacimiento'=>'required'

        ]);



        $this->aspirante=

            Aspirante::where(

                'cedula',

                $this->cedula

            )

            ->whereDate(

                'fecha_nacimiento',

                $this->fecha_nacimiento

            )

            ->first();



        if(!$this->aspirante){

            $this->addError(

                'cedula',

                'Datos incorrectos.'

            );

            return;

        }



        session([

            'psico_aspirante'=>

            $this->aspirante->id

        ]);

    }



    public function cerrarSesionPortal()
    {

        session()->forget(

            'psico_aspirante'

        );



        $this->reset(

            'cedula',

            'fecha_nacimiento',

            'aspirante',

            'testActual'

        );

    }



    public function iniciarTest($id)
    {

        $test=

            PsicoTest::findOrFail(
                $id
            );



        $sesion=

            PsicoSesion::where(

                'aspirante_id',

                $this->aspirante->id

            )

            ->where(

                'test_id',

                $test->id

            )

            ->where(

                'finalizado',

                false

            )

            ->first();



        if(!$sesion){

            $duracion=

                $test->duracion_minutos
                ??
                60;



            $sesion=

                PsicoSesion::create([

                    'aspirante_id'=>

                        $this->aspirante->id,

                    'test_id'=>

                        $test->id,

                    'inicio'=>

                        now(),

                    'expira_en'=>

                        now()->addMinutes(
                            $duracion
                        )

                ]);

        }



        $this->sesionExamen=
            $sesion;

        $this->testActual=$test;
        $this->preguntaActual=0;

        $this->respuestaSeleccionada=null;
        $this->cargarRespuestaActual();

        session([

            'psico_sesion'=>

                $sesion->id

        ]);

    }



    public function render()
    {

        $this->calcularTiempo();

        return view(

            'livewire.anb.ecb.psico-portal.index'

        );

    }

    private function calcularTiempo()
    {

        if(!$this->sesionExamen){

            return;

        }

        $this->segundosRestantes=

            now()

            ->diffInSeconds(

                $this->sesionExamen
                    ->expira_en,

                false

            );



        if(

            $this->segundosRestantes <= 0

        ){

            $this->sesionExamen
                ->update([

                    'finalizado'=>true

                ]);



            session()->forget(
                'psico_sesion'
            );



            $this->reset(

                'sesionExamen',

                'testActual',

                'segundosRestantes'

            );

        }

    }

   public function siguientePregunta()
{
    $preguntas=

        $this->testActual
            ->preguntas()
            ->orderBy('orden')
            ->get();

    $this->guardarRespuestaActual();

    if(
        isset(
            $preguntas[
                $this->preguntaActual + 1
            ]
        )
    ){

        $this->preguntaActual++;

        $this->cargarRespuestaActual();

    }
}


    public function cargarRespuestaActual()
    {

        $preguntas=

            $this->testActual
            ->preguntas()
            ->orderBy('orden')
            ->get();



        $pregunta=

            $preguntas[
                $this->preguntaActual
            ]

            ?? null;



        if(!$pregunta){

            return;

        }



        $respuesta=

            PsicoRespuesta::where(

                'sesion_id',

                $this->sesionExamen->id

            )

            ->where(

                'pregunta_id',

                $pregunta->id

            )

            ->first();



        $this->respuestaSeleccionada=

            $respuesta?->opcion_id;
    }

    public function preguntaAnterior()
    {

        if(

            $this->preguntaActual > 0

        ){

            $this->preguntaActual--;

            $this->cargarRespuestaActual();

        }

    }

    public function finalizarExamen()
{
    $this->guardarRespuestaActual();

    if($this->sesionExamen){

        $this->calcularResultado();

        $this->sesionExamen
            ->update([

                'finalizado'=>true

            ]);

    }

    session()->forget(
        'psico_sesion'
    );

    $this->reset(

        'testActual',

        'sesionExamen',

        'preguntaActual',

        'respuestaSeleccionada',

        'segundosRestantes'

    );
}


private function guardarRespuestaActual()
{
    $preguntas=

        $this->testActual
            ->preguntas()
            ->orderBy('orden')
            ->get();

    $pregunta=

        $preguntas[
            $this->preguntaActual
        ]

        ?? null;

    if(
        !$pregunta
    ){
        return;
    }

    if(
        is_null(
            $this->respuestaSeleccionada
        )
    ){
        return;
    }

    PsicoRespuesta::updateOrCreate(

        [

            'sesion_id'=>

                $this->sesionExamen->id,

            'pregunta_id'=>

                $pregunta->id

        ],

        [

            'opcion_id'=>

                $this->respuestaSeleccionada

        ]

    );
}




    public function estadoTest(
    $testId
    )
    {

        if(
            !$this->aspirante
        ){

            return null;
        }



        $sesion=

            PsicoSesion::where(

                'aspirante_id',

                $this->aspirante->id

            )

            ->where(

                'test_id',

                $testId

            )

            ->latest()

            ->first();



        if(
            !$sesion
        ){

            return 'pendiente';
        }



        if(
            $sesion->finalizado
        ){

            return 'completado';
        }



        return 'en_progreso';

    }




private function calcularResultado()
{

    if(
        !$this->sesionExamen
    ){

        return;
    }



    $codigo=

        $this->testActual
            ->codigo;



switch(
    $codigo
){

    case 'WONDERLIC':

        $this->calcularWonderlic();

    break;

    case 'NEOFFI':

        $this->calcularNeoFfi();

    break;

    case 'LSB50':

        $this->calcularLsb50();

    break;

}

}



private function calcularWonderlic()
{

    $puntaje=

        PsicoRespuesta::where(

            'sesion_id',

            $this->sesionExamen->id

        )

        ->whereHas(

            'opcion',

            function(
                $q
            ){

                $q->where(
                    'correcta',
                    true
                );

            }

        )

        ->count();



    $this->sesionExamen
        ->update([

            'puntaje'=>

                $puntaje

        ]);

}

private function calcularNeoFfi()
{
    $this->guardarResultadosPorDimension();
}

private function calcularLsb50()
{
    $this->guardarResultadosPorDimension();
}


private function guardarResultadosPorDimension()
{
    PsicoResultado::where(

        'sesion_id',

        $this->sesionExamen->id

    )->delete();



    $resultados=[];



    $respuestas=

        PsicoRespuesta::with(

            'pregunta.dimension',

            'opcion'

        )

        ->where(

            'sesion_id',

            $this->sesionExamen->id

        )

        ->get();



    foreach($respuestas as $respuesta){

        if(
            !$respuesta->pregunta?->dimension
        ){
            continue;
        }



        $dimensionId=

            $respuesta
                ->pregunta
                ->dimension
                ->id;



        $valor=

            $respuesta
                ->opcion
                ?->valor

            ?? 0;



        if(
            !isset(
                $resultados[$dimensionId]
            )
        ){

            $resultados[$dimensionId]=0;

        }



        $resultados[$dimensionId]+=$valor;
    }



    foreach(

        $resultados

        as

        $dimensionId=>$puntaje

    ){

        PsicoResultado::create([

            'sesion_id'=>

                $this->sesionExamen->id,

            'dimension_id'=>

                $dimensionId,

            'puntaje'=>

                $puntaje

        ]);

    }
}


}