<?php

namespace Database\Seeders;

use App\Models\Personal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalMigracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog();

        DB::transaction(function () {

        /*
        |--------------------------------------------------------------------------
        | 1. ACTUALIZAR LOS QUE FALTAN ACTUALIZAR
        |--------------------------------------------------------------------------
        */

            $falta_actualizar = DB::table('personal')
                ->where('estado_actualizar_id', 1)
                ->whereNotIn('codigo', [
                    # CODIGOS DUPLICADOS
                    17,
                    88,
                    438,
                    597,
                    2823,
                    3129,
                    3131,
                    3132,
                    3133,
                    3134,
                    3137,
                    3432,
                    3442,
                    6453,
                    9821,
                    10602
                ])
                ->select('idpersonal', 'codigo', 'fecha_juramento')
                ->get();

            foreach ($falta_actualizar as $registro) {

                $migrado = DB::table('personal_migrar')
                    ->where('codigo', $registro->codigo)
                    ->where('fecha_juramento', $registro->fecha_juramento)
                    ->first();

                if (!$migrado) {
                    continue;
                }

                DB::table('personal')
                    ->where('idpersonal', $registro->idpersonal)
                    ->update([
                        'nombrecompleto'        => $migrado->nombrecompleto,
                        'categoria_id'          => $migrado->categoria_id,
                        'compania_id'           => $migrado->compania_id,
                        'fecha_juramento'       => $migrado->fecha_juramento,
                        'fecha_de_juramento'    => $migrado->fecha_de_juramento,
                        'fecha_nacimiento'      => $migrado->fecha_nacimiento,
                        'estado_id'             => $migrado->estado_id,
                        'documento'             => $migrado->documento,
                        'sexo_id'               => $migrado->sexo_id,
                        'nacionalidad_id'       => $migrado->nacionalidad_id,
                        'grupo_sanguineo_id'    => $migrado->grupo_sanguineo_id,
                        'tipo_documento_id'     => $migrado->tipo_documento_id,
                        'estado_actualizar_id'  => 3, # Actualizado Excel
                        'ultima_actualizacion'  => now(),
                    ]);
            }

        /*
        |--------------------------------------------------------------------------
        | 2. INSERTAR LOS QUE NO EXISTEN EN personal
        |--------------------------------------------------------------------------
        */

            $nuevos = DB::table('personal_migrar')->get();

            foreach ($nuevos as $migrado) {

                $existe = DB::table('personal')
                    ->where('codigo', $migrado->codigo)
                    ->where('fecha_juramento', $migrado->fecha_juramento)
                    // ->whereNotIn('codigo', [
                    //     5, 6, 14, 20, 21, 24, 77, 100, 107, 110,
                    //     128, 136, 177, 191, 198, 218, 227, 234,
                    //     275, 283, 285, 287, 295, 296, 309, 316,
                    //     318, 323, 326, 343, 373, 376, 383, 389,
                    //     397, 398, 402, 429, 433, 444, 542, 567,
                    //     587, 597, 608, 746, 2823, 2907, 3123,
                    //     3124, 3127, 3129, 3131, 3132, 3133,
                    //     3134, 5828, 6614
                    // ])
                    ->exists();

                if ($existe) {
                    continue;
                }

                DB::table('personal')->insert([
                    'nombrecompleto'        => $migrado->nombrecompleto,
                    'codigo'                => $migrado->codigo,
                    'categoria_id'          => $migrado->categoria_id,
                    'compania_id'           => $migrado->compania_id,
                    'fecha_juramento'       => $migrado->fecha_juramento,
                    'fecha_de_juramento'    => $migrado->fecha_de_juramento,
                    'fecha_nacimiento'      => $migrado->fecha_nacimiento,
                    'estado_id'             => $migrado->estado_id,
                    'documento'             => $migrado->documento,
                    'sexo_id'               => $migrado->sexo_id,
                    'nacionalidad_id'       => $migrado->nacionalidad_id,
                    'grupo_sanguineo_id'    => $migrado->grupo_sanguineo_id,
                    'tipo_documento_id'     => $migrado->tipo_documento_id,
                    'estado_actualizar_id'  => 4, # Insert Excel
                    'ultima_actualizacion'  => now(),
                ]);
            }
        });
    }
}
