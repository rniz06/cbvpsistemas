<?php

namespace Database\Seeders\ANB\ECB\Psicologia\LSB50;

use Illuminate\Database\Seeder;
use App\Models\ANB\ECB\PsicoTest;
use App\Models\ANB\ECB\PsicoDimension;

class Lsb50DimensionesSeeder extends Seeder
{
    public function run(): void
    {
        $test = PsicoTest::where(
            'codigo',
            'LSB50-ORIGINAL'
        )->firstOrFail();

        $dimensiones = [

            [
                'orden'=>1,
                'codigo'=>'MIN',
                'nombre'=>'Minimización',
                'divisor'=>8
            ],

            [
                'orden'=>2,
                'codigo'=>'MAG',
                'nombre'=>'Magnificación',
                'divisor'=>8
            ],

            [
                'orden'=>3,
                'codigo'=>'PR',
                'nombre'=>'Psicorreactividad',
                'divisor'=>14
            ],

            [
                'orden'=>4,
                'codigo'=>'HP',
                'nombre'=>'Hipersensibilidad',
                'divisor'=>7
            ],

            [
                'orden'=>5,
                'codigo'=>'OB',
                'nombre'=>'Obsesión - Compulsión',
                'divisor'=>7
            ],

            [
                'orden'=>6,
                'codigo'=>'AN',
                'nombre'=>'Ansiedad',
                'divisor'=>9
            ],

            [
                'orden'=>7,
                'codigo'=>'HS',
                'nombre'=>'Hostilidad',
                'divisor'=>6
            ],

            [
                'orden'=>8,
                'codigo'=>'SM',
                'nombre'=>'Somatización',
                'divisor'=>8
            ],

            [
                'orden'=>9,
                'codigo'=>'DE',
                'nombre'=>'Depresión',
                'divisor'=>10
            ],

            [
                'orden'=>10,
                'codigo'=>'SU',
                'nombre'=>'Alteraciones del Sueño',
                'divisor'=>3
            ],

            [
                'orden'=>11,
                'codigo'=>'SUA',
                'nombre'=>'Alteraciones del Sueño Ampliada',
                'divisor'=>7
            ],

            [
                'orden'=>12,
                'codigo'=>'IRPSI',
                'nombre'=>'Índice de Riesgo Psicopatológico',
                'divisor'=>12
            ],
            [
                'orden'=>13,
                'codigo'=>'GLOBAL',
                'nombre'=>'Índice Global de Severidad',
                'divisor'=>1
            ],

            [
                'orden'=>14,
                'codigo'=>'NUM',
                'nombre'=>'Número de Síntomas Presentes',
                'divisor'=>1
            ],

            [
                'orden'=>15,
                'codigo'=>'INT',
                'nombre'=>'Índice de Intensidad',
                'divisor'=>1
            ],

        ];

        foreach($dimensiones as $dimension){

            PsicoDimension::updateOrCreate(

                [

                    'test_id'=>$test->id,

                    'codigo'=>$dimension['codigo']

                ],

                [

                    'orden'=>$dimension['orden'],

                    'nombre'=>$dimension['nombre'],

                    'divisor'=>$dimension['divisor']

                ]

            );

        }

    }
}