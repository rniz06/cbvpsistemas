<?php

namespace Database\Seeders\Personal\Asistencia;

use App\Models\Personal\Asistencia\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=Database\\Seeders\\Personal\\Asistencia\\EstadoSeeder
     */
    public function run(): void
    {
        Estado::create(['estado' => 'NO INICIADO']);
        Estado::create(['estado' => 'SIN CARGAR']);
        Estado::create(['estado' => 'REMITIDO P/ VERIFICAR']);
        Estado::create(['estado' => 'APROBADO POR PERSONAL']);
        Estado::create(['estado' => 'RECHAZADO POR PERSONAL']);
        Estado::create(['estado' => 'APROBADO POR COMANDANCIA']);
        Estado::create(['estado' => 'RECHAZADO POR COMANDANCIA']);
    }
}
