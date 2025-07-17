<?php

namespace Database\Seeders;

use App\Models\Cca\Servicios\Existente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicioExistenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existentes = Existente::factory()->count(100)->create();
    }
}
