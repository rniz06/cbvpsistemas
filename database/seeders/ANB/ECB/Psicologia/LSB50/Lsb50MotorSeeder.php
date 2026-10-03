<?php

namespace Database\Seeders\ANB\ECB\Psicologia\LSB50;

use Illuminate\Database\Seeder;
use App\Models\ANB\ECB\PsicoTest;
use App\Models\ANB\ECB\PsicoPregunta;
use App\Models\ANB\ECB\PsicoDimension;
use App\Models\ANB\ECB\PsicoDimensionPregunta;

class Lsb50MotorSeeder extends Seeder
{
    public function run(): void
    {
        $test = PsicoTest::where(
            'codigo',
            'LSB50-ORIGINAL'
        )->firstOrFail();

        $motor = [

            1  => ['SM'],

            2  => ['MIN','DE','SUA'],

            3  => ['HS'],

            4  => ['MIN','AN'],

            5  => ['MAG','SM','IRPSI'],

            6  => ['PR','OB'],

            7  => ['PR','OB'],

            8  => ['PR','OB'],

            9  => ['MIN','HS'],

            10 => ['MAG','AN'],

            11 => ['MIN','SM'],

            12 => ['MIN','DE'],

            13 => ['MIN','SU','SUA'],

            14 => ['SU','SUA'],

            15 => ['PR','OB'],

            16 => ['PR','HP'],

            17 => ['MAG','DE','IRPSI'],

            18 => ['AN','IRPSI'],

            19 => ['SM'],

            20 => ['SM'],

            21 => ['DE'],

            22 => ['MAG','AN','IRPSI'],

            23 => ['HS'],

            24 => ['PR','HP'],

            25 => ['AN','IRPSI'],

            26 => ['MAG','PR','HP'],

            27 => ['SU','SUA'],

            28 => ['DE'],

            29 => ['MAG','PR','HP','IRPSI'],

            30 => ['MIN','PR','HP'],

            31 => ['PR','OB','IRPSI'],

            32 => ['DE','IRPSI'],

            33 => ['PR','OB'],

            34 => ['AN','SUA','IRPSI'],

            35 => ['AN'],

            36 => ['PR','OB'],

            37 => ['DE','SUA'],

            38 => ['PR','HP'],

            39 => ['DE'],

            40 => ['PR','HP'],

            41 => ['HS'],

            42 => ['MAG','DE','IRPSI'],

            43 => ['SM'],

            44 => ['HS'],

            45 => ['SM'],

            46 => ['MAG','SM'],

            47 => ['AN','IRPSI'],

            48 => ['HS'],

            49 => ['MIN','DE'],

            50 => ['AN','SUA','IRPSI'],

        ];
                foreach($motor as $ordenPregunta => $codigos){

            $pregunta = PsicoPregunta::where(
                'test_id',
                $test->id
            )
            ->where(
                'orden',
                $ordenPregunta
            )
            ->firstOrFail();

            foreach($codigos as $codigo){

                $dimension = PsicoDimension::where(
                    'test_id',
                    $test->id
                )
                ->where(
                    'codigo',
                    $codigo
                )
                ->firstOrFail();

                PsicoDimensionPregunta::updateOrCreate(

                    [

                        'pregunta_id' => $pregunta->id,

                        'dimension_id' => $dimension->id

                    ]

                );

            }

        }

    }

}