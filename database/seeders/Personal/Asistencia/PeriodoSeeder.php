<?php

namespace Database\Seeders\Personal\Asistencia;

use App\Models\Personal\Asistencia\Periodo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=Database\\Seeders\\Personal\\Asistencia\\PeriodoSeeder
     */
    public function run(): void
    {
        // Periodo Octubre 2025
        Periodo::create(['anho_id' => 1, 'mes_id' => 10]);

        // Periodo Noviembre 2025
        Periodo::create(['anho_id' => 1, 'mes_id' => 11]);

        // Periodo Diciembre 2025
        Periodo::create(['anho_id' => 1, 'mes_id' => 12]);
    }
}
