<?php

namespace Database\Seeders\ANB\ECB\Psicologia\LSB50;

use Illuminate\Database\Seeder;

use App\Models\ANB\ECB\PsicoTest;
use App\Models\ANB\ECB\PsicoPregunta;
use App\Models\ANB\ECB\PsicoOpcion;

class Lsb50OpcionesSeeder extends Seeder
{
    public function run(): void
    {
        $test = PsicoTest::where(
            'codigo',
            'LSB50-ORIGINAL'
        )->firstOrFail();

        $opciones = [

            0 => 'Nada',

            1 => 'Poco',

            2 => 'Moderadamente',

            3 => 'Bastante',

            4 => 'Mucho'

        ];

        $preguntas = PsicoPregunta::where(
            'test_id',
            $test->id
        )->get();

        foreach($preguntas as $pregunta){

            foreach($opciones as $valor=>$texto){

                PsicoOpcion::updateOrCreate(

                    [

                        'pregunta_id'=>$pregunta->id,

                        'valor'=>$valor

                    ],

                    [

                        'texto'=>$texto

                    ]

                );

            }

        }

    }
}