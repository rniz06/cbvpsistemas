<?php

namespace App\Livewire\ANB\ECB\PsicoMotor;

use Livewire\Component;

use App\Models\ANB\ECB\PsicoTest;
use App\Models\ANB\ECB\PsicoPregunta;
use App\Models\ANB\ECB\PsicoDimension;
use App\Models\ANB\ECB\PsicoDimensionPregunta;

class Index extends Component
{
    public PsicoTest $test;
    public $relaciones = [];

    public function mount($test_id)
    {
        $this->test = PsicoTest::findOrFail($test_id);

        $relaciones = PsicoDimensionPregunta::whereHas(
            'pregunta',
            function ($q) {
                $q->where(
                    'test_id',
                    $this->test->id
                );
            }
        )->get();

        foreach ($relaciones as $r) {

            $this->relaciones[
                $r->pregunta_id
            ][
                $r->dimension_id
            ] = true;

        }
    }

public function toggleRelacion(
    $pregunta_id,
    $dimension_id
)
{

    $relacion = PsicoDimensionPregunta::where(
        'pregunta_id',
        $pregunta_id
    )

    ->where(
        'dimension_id',
        $dimension_id
    )

    ->first();


    if($relacion){

        $relacion->delete();

        unset(

            $this->relaciones
                [$pregunta_id]
                [$dimension_id]

        );

    }else{

        PsicoDimensionPregunta::create([

            'pregunta_id'=>$pregunta_id,

            'dimension_id'=>$dimension_id

        ]);

        $this->relaciones
            [$pregunta_id]
            [$dimension_id]
            = true;

    }

}

    public function render()
    {
        $preguntas = PsicoPregunta::where(
            'test_id',
            $this->test->id
        )
        ->orderBy('orden')
        ->get();

        $dimensiones = PsicoDimension::where(
            'test_id',
            $this->test->id
        )
        ->orderBy('orden')
        ->get();

        return view(
            'livewire.anb.ecb.psico-motor.index',
            compact(
                'preguntas',
                'dimensiones'
            )
        );
    }
}