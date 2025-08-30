<?php

namespace Database\Seeders\Personal;

use App\Models\Personal\Rango;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RangoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=Database\\Seeders\\Personal\\RangoSeeder
     */
    public function run(): void
    {
        $rangos = [
            "CAPITÁN GENERAL",
            "CAPITÁN PRINCIPAL",
            "CAPITÁN DIRECTOR",
            "CAPITÁN MAYOR",
            "CAPITÁN INSPECTOR",
            "CAPITÁN",
            "TENIENTE PRIMERO",
            "TENIENTE",
        ];

        foreach ($rangos as $rango) {
            Rango::create([
                'rango' => $rango,
                'creadoPor' => 10231
            ]);
        }
    }
}
