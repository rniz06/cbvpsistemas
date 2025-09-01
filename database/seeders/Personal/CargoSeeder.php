<?php

namespace Database\Seeders\Personal;

use App\Enums\Personal\Cargo\TipoCodigo;
use App\Models\Personal\Cargo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=Database\\Seeders\\Personal\\CargoSeeder
     */
    public function run(): void
    {
        $cargos = [
            // MIEMBROS DEL DIRECTORIO NACIONAL
            [
                'cargo' => 'PRESIDENTE NACIONAL',
                'codigo_base' => 'A1',
                'tipo_codigo' => TipoCodigo::FIJO,
                'rango_id' => 1, // CAPITAN GENERAL
            ],
            [
                'cargo' => 'VICEPRESIDENTE NACIONAL',
                'codigo_base' => 'A2',
                'tipo_codigo' => TipoCodigo::FIJO,
                'rango_id' => 2, // CAPITAN PRINCIPAL
            ],
            [
                'cargo' => 'COMANDANTE NACIONAL',
                'codigo_base' => 'C1',
                'tipo_codigo' => TipoCodigo::FIJO,
                'rango_id' => 2,
            ],
            [
                'cargo' => '2DO COMANDANTE NACIONAL',
                'codigo_base' => 'C2',
                'tipo_codigo' => TipoCodigo::FIJO,
                'rango_id' => 2,
            ],
            [
                'cargo' => 'SECRETARIO NACIONAL',
                'codigo_base' => 'A3',
                'tipo_codigo' => TipoCodigo::FIJO,
                'rango_id' => 2,
            ],
            [
                'cargo' => 'TESORERO NACIONAL',
                'codigo_base' => 'A4',
                'tipo_codigo' => TipoCodigo::FIJO,
                'rango_id' => 2,
            ],
            [
                'cargo' => 'DIRECTOR NACIONAL',
                'codigo_base' => 'A5',
                'tipo_codigo' => TipoCodigo::FIJO,
                'rango_id' => 2,
            ],
            [
                'cargo' => '3ER COMANDANTE NACIONAL',
                'codigo_base' => 'C3',
                'tipo_codigo' => TipoCodigo::FIJO,
                'rango_id' => 2,
            ],
            [
                'cargo' => 'PROSECRETARIO NACIONAL',
                'codigo_base' => 'A6',
                'tipo_codigo' => TipoCodigo::FIJO,
                'rango_id' => 2,
            ],
            [
                'cargo' => 'PROTESORERO NACIONAL',
                'codigo_base' => 'A7',
                'tipo_codigo' => TipoCodigo::FIJO,
                'rango_id' => 2,
            ],
            [
                'cargo' => 'PRODIRECTOR NACIONAL',
                'codigo_base' => 'A8',
                'tipo_codigo' => TipoCodigo::FIJO,
                'rango_id' => 2,
            ],

            // JUNTA ELECTORAL Y TRIBUNAL DE JUSTICIA
            [
                'cargo' => 'MIEMBRO TITULAR',
                //'codigo_base' => '',
                'tipo_codigo' => TipoCodigo::VARIABLE,
                'rango_id' => 3, // CAPITAN DIRECTOR
            ],
            [
                'cargo' => 'MIEMBRO SUPLENTE',
                //'codigo_base' => '',
                'tipo_codigo' => TipoCodigo::VARIABLE,
                'rango_id' => 3,
            ],

            // CARGOS DENTRO DE LA COMPANIA
            [
                'cargo' => 'COMANDANTE DE COMPANIA',
                //'codigo_base' => '',
                'tipo_codigo' => TipoCodigo::COMPANIA,
                'rango_id' => 4, // CAPITAN DIRECTOR
            ],
            [
                'cargo' => '1ER OFICIAL DE COMPANIA',
                //'codigo_base' => '',
                'tipo_codigo' => TipoCodigo::COMPANIA,
                'rango_id' => 7,
            ],
            [
                'cargo' => '2DO OFICIAL DE COMPANIA',
                //'codigo_base' => '',
                'tipo_codigo' => TipoCodigo::COMPANIA,
                'rango_id' => 8, // TENIENTE
            ],
            [
                'cargo' => 'ADMINISTRADOR DE COMPANIA',
                //'codigo_base' => '',
                'tipo_codigo' => TipoCodigo::COMPANIA,
                'rango_id' => 8, // TENIENTE
            ],

            // OTROS CARGOS
            [
                'cargo' => 'DIRECTOR',
                //'codigo_base' => '',
                'tipo_codigo' => TipoCodigo::VARIABLE,
                'rango_id' => 5, // CAPITAN INSPECTOR
            ],
            [
                'cargo' => 'SUB DIRECTOR',
                //'codigo_base' => '',
                'tipo_codigo' => TipoCodigo::VARIABLE,
                'rango_id' => 6, // CAPITAN
            ],
            [
                'cargo' => 'AYUDANTE DE DPTO',
                //'codigo_base' => '',
                'tipo_codigo' => TipoCodigo::VARIABLE,
                'rango_id' => 8, // TENIENTE
            ],
        ];

        foreach ($cargos as $cargo) {
            Cargo::create([
                ...$cargo, // array unpacking
                'creadoPor' => 10231, // ID del Usuario Marcos Meza
            ]);
        }
    }
}
