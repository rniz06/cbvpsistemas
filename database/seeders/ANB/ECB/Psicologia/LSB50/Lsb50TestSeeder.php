<?php

namespace Database\Seeders\ANB\ECB\Psicologia\LSB50;

use Illuminate\Database\Seeder;
use App\Models\ANB\ECB\PsicoTest;

class Lsb50TestSeeder extends Seeder
{
    public function run(): void
    {
        PsicoTest::updateOrCreate(

            [

                'codigo' => 'LSB50-ORIGINAL'

            ],

            [

                'nombre' => 'LSB-50 ORIGINAL',

                'descripcion' => 'Versión oficial del Listado de Síntomas Breve LSB-50.',

                'duracion_minutos' => 20,

                'activo' => true

            ]

        );
    }
}