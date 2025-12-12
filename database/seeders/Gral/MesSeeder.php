<?php

namespace Database\Seeders\Gral;

use App\Models\Gral\Mes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=Database\\Seeders\\Gral\\MesSeeder
     */
    public function run(): void
    {
        Mes::create(['mes' => 'ENERO', 'numero' => 1]);
        Mes::create(['mes' => 'FEBRERO', 'numero' => 2]);
        Mes::create(['mes' => 'MARZO', 'numero' => 3]);
        Mes::create(['mes' => 'ABRIL', 'numero' => 4]);
        Mes::create(['mes' => 'MAYO', 'numero' => 5]);
        Mes::create(['mes' => 'JUNIO', 'numero' => 6]);
        Mes::create(['mes' => 'JULIO', 'numero' => 7]);
        Mes::create(['mes' => 'AGOSTO', 'numero' => 8]);
        Mes::create(['mes' => 'SEPTIEMBRE', 'numero' => 9]);
        Mes::create(['mes' => 'OCTUBRE', 'numero' => 10]);
        Mes::create(['mes' => 'NOVIEMBRE', 'numero' => 11]);
        Mes::create(['mes' => 'DICIEMBRE', 'numero' => 12]);
    }
}
