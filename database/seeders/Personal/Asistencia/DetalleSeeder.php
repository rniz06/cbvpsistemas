<?php

namespace Database\Seeders\Personal\Asistencia;

use App\Models\Personal;
use App\Models\Personal\Asistencia\Detalle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=Database\\Seeders\\Personal\\Asistencia\\DetalleSeeder
     */
    public function run(): void
    {
        $personales = Personal::select('idpersonal')->where('compania_id', 19)->get();

        foreach ($personales as $personal) {
            Detalle::create([
                'asistencia_id' => 1,
                'personal_id'   => $personal->idpersonal,
                'practica'      => null,
                'guardia'       => null,
                'citacion'      => null,
            ]);
        }
    }
}
