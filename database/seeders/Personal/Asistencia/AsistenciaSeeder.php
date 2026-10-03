<?php

namespace Database\Seeders\Personal\Asistencia;

use App\Models\Personal\Asistencia\Asistencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=Database\\Seeders\\Personal\\Asistencia\\AsistenciaSeeder
     */
    public function run(): void
    {
        // ASISTENCIA COMPANIA K15 PERIODO OCTUBRE 2025 ESTADO SIN CARGAR
        Asistencia::create(['compania_id' => 19, 'periodo_id' => 1, 'estado_id' => 2]);
        
        // ASISTENCIA COMPANIA K15 PERIODO NOVIEMBRE 2025 ESTADO NO INICIADO
        Asistencia::create(['compania_id' => 19, 'periodo_id' => 2, 'estado_id' => 1]);

        // ASISTENCIA COMPANIA K15 PERIODO DICIEMBRE 2025 ESTADO NO INICIADO
        Asistencia::create(['compania_id' => 19, 'periodo_id' => 3, 'estado_id' => 1]);
    }
}
