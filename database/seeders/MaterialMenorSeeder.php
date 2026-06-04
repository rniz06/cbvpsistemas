<?php

namespace Database\Seeders;

use App\Models\Materiales\Menor\Categoria;
use App\Models\Materiales\Menor\Tipo;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialMenorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # CREAR TIPOS
        $tipos = ['MATERIAL MENOR', 'ERAS'];
        foreach ($tipos as $tipo) {
            Tipo::create([
                'tipo'    => $tipo,
                'creadoPor' => 10231, # USUARIO: MARCOS MEZA
            ]);
        }

        # CREAR CATEGORIAS
        $categorias = [
            'ERAS',
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

        // Permission::create([
        //     'name' => 'Material Menor Ver Compania',
        //     'guard_name' => 'web',
        //     'modulo_id' => 5,
        //     'sub_modulo_id' => 7,
        // ]);
    }
}
