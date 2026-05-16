<?php

namespace Database\Seeders;

use App\Models\Materiales\Menor\Categoria;
use App\Models\Materiales\Menor\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialMenor2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # CREAR TIPOS
        $tipos = ['MATERIAL MENOR', 'EQUIPOS FORESTALES', 'ERAS'];
        foreach ($tipos as $tipo) {
            Tipo::create([
                'tipo'    => $tipo,
                'creadoPor' => 10231, # USUARIO: MARCOS MEZA
            ]);
        }

        # CREAR CATEGORIAS
        $categorias = [
            'EQUIPOS DE COMUNICACION',
            'EQUIPOS DE EXTINCION',
            'EQUIPOS FORESTALES',
            'EQUIPOS PARA RESCATE VERTICAL Y FIJACION',
            'EQUIPOS Y HERRAMIENTAS MANUALES',
            'EQUIPOS Y HERRAMIENTAS MOTORIZADAS'
        ];

        foreach ($categorias as $categoria) {
            Categoria::create([
                'nombre'    => $categoria,
                'creadoPor' => 10231, # USUARIO: MARCOS MEZA
            ]);
        }
    }
}
