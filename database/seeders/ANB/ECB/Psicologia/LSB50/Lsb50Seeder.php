<?php

namespace Database\Seeders\ANB\ECB\Psicologia\LSB50;

use Illuminate\Database\Seeder;

class Lsb50Seeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            Lsb50TestSeeder::class,

            Lsb50DimensionesSeeder::class,

            Lsb50PreguntasSeeder::class,

            Lsb50OpcionesSeeder::class,

            Lsb50MotorSeeder::class,

            Lsb50BaremosVaronesSeeder::class,

            Lsb50BaremosMujeresSeeder::class,

        ]);
    }
}