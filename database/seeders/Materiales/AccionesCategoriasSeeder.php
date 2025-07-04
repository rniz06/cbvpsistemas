<?php

namespace Database\Seeders\Materiales;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccionesCategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ID de la acción "FUERA DE SERVICIO"
        $accionId = 2;

        // Datos estructurados
        $categorias = [
            'MECANICO' => [
                'MOTOR',
                'DIRECCION',
                'FRENOS',
                'TRANSMISION O CAJA',
                'CARGA DE AIRE',
                'REFRIGERACION MOTOR',
                'OTRO PROBLEMA',
            ],
            'ELECTRICO' => [
                'ALTERNADOR',
                'CABLEADO',
                'TABLERO',
                'FUSIBLES',
                'LUCES',
                'BATERIA',
                'OTRO PROBLEMA',
            ],
            'NEUMATICOS Y LLANTAS' => [
                'PINCHADURA',
                'CORTE O DEFORMACION',
                'DESGASTE EXCESIVO',
                'LLANTA DEFORMADA',
                'LLANTA CORROIDA',
                'FALTA O DAÑO DE PRISIONERO',
                'OTRO PROBLEMA',
            ],
            'PERDIDA DE' => [
                'FLUIDO HIDRAULICO',
                'FLUIDO DE FRENOS',
                'ACEITE MOTOR',
                'ACEITE CAJA',
                'ACEITE REDUCTORA',
                'AGUA',
                'AIRE',
            ],
            'CARROCERIA' => [
                'CORROSION EXCESIVA',
                'PUERTA/BAUL/CAJONERA',
                'VIDRIOS',
                'OTRO PROBLEMA',
            ],
            'INCIDENTE' => [
                'ROCE',
                'CHOQUE',
                'OTRO PROBLEMA',
            ],
            'OTRA SITUACION' => [
                'TANQUE DE AGUA',
                'BOMBEO DE AGUA',
                'OTRA SITUACION',
                'FUERA DE SERVICIO MOMENTANEO',
            ],
            'BAJA' => [
                'SOLICITAR LA BAJA',
            ],
        ];

        foreach ($categorias as $categoria => $detalles) {
            // Insertar categoría
            $categoriaId = DB::table('MAT_acciones_categorias')->insertGetId([
                'categoria' => $categoria,
                'accion_id' => $accionId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insertar detalles asociados
            foreach ($detalles as $detalle) {
                DB::table('MAT_acciones_categorias_detalles')->insert([
                    'detalle' => $detalle,
                    'accion_categoria_id' => $categoriaId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
