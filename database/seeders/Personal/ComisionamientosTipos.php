<?php

namespace Database\Seeders\Personal;

use App\Models\Personal\ComisionamientoTipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComisionamientosTipos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            "AUTORIDAD ELECTA",
            "COMISIONADO",
        ];

        foreach ($tipos as $tipo) {
            ComisionamientoTipo::create([
                'tipo' => $tipo,
            ]);
        }
    }
}
