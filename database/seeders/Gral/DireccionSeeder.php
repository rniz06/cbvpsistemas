<?php

namespace Database\Seeders\Gral;

use App\Models\Gral\Direccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DireccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=Database\\Seeders\\Gral\\DireccionSeeder
     */
    public function run(): void
    {
        $direcciones = [
            // DIRECTORIO ID: 121
            121 => [
                "PRESIDENCIA NACIONAL",
                "DPTO. LEGAL",
                "DPTO. RR. INTERNACIONALES",
                "DPTO. RR. INTERMUNICIPALES",
                "DPTO. DE RELACIONES PÚBLICAS",
                "SECRETARIA NACIONAL",
                "MESA DE ENTRADA",
                "ARCHIVOS",
                "DPTO. DE TECNOLOGÍA E INNOVACIÓN",
                "DPTO. RR. INTERINSTINACIONALES",
                "TESORERÍA NACIONAL",
                "DPTO. DE PATRIMONIO",
                "DPTO. DE ECONOMÍA",
                "DPTO. DE CONTABILIDAD",
                "DIRECCIÓN NACIONAL",
                "DPTO. DE DESARROLLO Y EXPANSIÓN",
                "DPTO. DE OBRAS",
            ],

            // COMANDANCIA ID: 70
            70 => [
                "COMANDANCIA NACIONAL",
                "DPTO. DE SEGURIDAD Y BIENESTAR",
                "DPTO. PRE-HOSPITALAR",
                "DPTO. DE MANT. MATERIALES",
                "DPTO. DE PERSONAL",
                "DPTO. DE COMUNICACIONES",
                "DPTO. DE PREV. E INVESTIGACIÓN DE SINIESTROS",
                "DPTO. DE DESARROLLO Y FISCALIZACIÓN",
                "DPTO. DE MEDIO AMBIENTE",
            ],

            // ANB ID: 132
            // 132 => [
            //     "SECRETARIA GENERAL",
            //     "ESCUELA DE CAPACITACIÓN BÁSICA",
            //     "ESCUELA DE CAPACITACIÓN TÉCNICA",
            //     "ESCUELA DE ESTUDIOS SUPERIORES",
            // ],
        ];

        foreach ($direcciones as $companiaId => $listaDirecciones) {
            foreach ($listaDirecciones as $direccion) {
                Direccion::create([
                    'direccion' => $direccion,
                    'compania_id' => $companiaId,
                    'creadoPor' => 10231
                ]);
            }
        }
    }
}
