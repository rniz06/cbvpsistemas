<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalMigracionSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        DB::transaction(function () {

            $audits = [];
            $now = now();

            /*
            |--------------------------------------------------------------------------
            | 1. ACTUALIZAR LOS QUE FALTAN ACTUALIZAR
            |--------------------------------------------------------------------------
            */

            DB::table('personal')
                ->where('estado_actualizar_id', 1) # Falta Actualizar
                ->whereNotIn('codigo', [
                    17,88,438,597,2823,3129,3131,3132,3133,3134,3137, # CODIGOS EXISTENTES YA DUPLICADOS
                    3432,3442,6453,9821,10602
                ])
                ->select('idpersonal', 'codigo', 'fecha_juramento')
                ->orderBy('idpersonal')
                # REALIZAR OPERACION POR LOTES DE A 500
                ->chunk(500, function ($registros) use (&$audits, $now) {

                    foreach ($registros as $registro) {

                        $migrado = DB::table('personal_migrar')
                            ->where('codigo', $registro->codigo)
                            ->where('fecha_juramento', $registro->fecha_juramento)
                            ->first();

                        if (!$migrado) {

                            $audits[] = [
                                'personal_id' => $registro->idpersonal,
                                'codigo' => $registro->codigo,
                                'operacion' => 'skip',
                                'motivo' => 'No encontrado en personal_migrar',
                                'datos_origen' => null,
                                'datos_destino' => null,
                                'fechaHoraOperacion' => $now
                            ];

                            continue;
                        }

                        $personal_actual = DB::table('personal')
                            ->where('idpersonal', $registro->idpersonal)
                            ->first();

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
                                'ultima_actualizacion'  => $now,
                            ]);

                        $audits[] = [
                            'personal_id' => $registro->idpersonal,
                            'codigo' => $registro->codigo,
                            'operacion' => 'update',
                            'motivo' => null,
                            'datos_origen' => json_encode($migrado),
                            'datos_destino' => json_encode($personal_actual),
                            'fechaHoraOperacion' => $now
                        ];

                        if (count($audits) >= 1000) {
                            DB::table('personal_audits_migracion')->insert($audits);
                            $audits = [];
                        }
                    }
                });


            /*
            |--------------------------------------------------------------------------
            | 2. INSERTAR LOS QUE NO EXISTEN
            |--------------------------------------------------------------------------
            */

            DB::table('personal_migrar')
                ->orderBy('codigo')
                ->chunk(500, function ($nuevos) use (&$audits, $now) {

                    foreach ($nuevos as $migrado) {

                        $existe = DB::table('personal')
                            ->where('codigo', $migrado->codigo)
                            ->where('fecha_juramento', $migrado->fecha_juramento)
                            ->exists();

                        if ($existe) {

                            $audits[] = [
                                'personal_id' => null,
                                'codigo' => $migrado->codigo,
                                'operacion' => 'skip',
                                'motivo' => 'Registro ya existe',
                                'datos_origen' => null,
                                'datos_destino' => null,
                                'fechaHoraOperacion' => $now
                            ];

                            continue;
                        }

                        $personal_id = DB::table('personal')->insertGetId([
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
                            'ultima_actualizacion'  => $now,
                        ]);

                        $audits[] = [
                            'personal_id' => $personal_id,
                            'codigo' => $migrado->codigo,
                            'operacion' => 'insert',
                            'motivo' => null,
                            'datos_origen' => json_encode($migrado),
                            'datos_destino' => null,
                            'fechaHoraOperacion' => $now
                        ];

                        if (count($audits) >= 1000) {
                            DB::table('personal_audits_migracion')->insert($audits);
                            $audits = [];
                        }
                    }
                });


            /*
            |--------------------------------------------------------------------------
            | INSERT FINAL DE AUDITORIA
            |--------------------------------------------------------------------------
            */

            if (!empty($audits)) {
                DB::table('personal_audits_migracion')->insert($audits);
            }

        });
    }
}
