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
                        'estado_actualizar_id'  => 2,
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
                    'estado_actualizar_id'  => 2,
                    'ultima_actualizacion'  => now(),
                ]);
            }
        });
    }
}
