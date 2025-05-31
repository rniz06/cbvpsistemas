<?php

namespace App\Console\Commands\GadmaMigracion\Hidraulicos;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportarHidraulicosConComentariosDesdeVista extends Command
{
    /**
     * Importa datos de la vista materialescbvp.vt_companias_tienen_hidraulicos
     * a personalcbvp.MAT_hidraulicos obteniendo tambien los comentarios relacionados
     * a cada registro de la vista desde materialescbvp.vt_comentarios_hidraulicos e irnsentandolos
     * en la tabla personalcbvp.MAT_hidraulicos_comentarios con los nuevos ids.
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:importar-hidraulicos-con-comentarios-desde-vista';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Iniciando importación...");

        // Obtener todos los registros de hidraulicos de la tabla origen
        $registros = DB::table('materialescbvp.vt_companias_tienen_hidraulicos')->get();

        foreach ($registros as $registro) {
            // 1. Insertar el móvil en la nueva tabla y obtener el ID generado
            $nuevoIdHidraulico = DB::table('personalcbvp.MAT_hidraulicos')->insertGetId([
                'anho'             => $registro->ano ?? null,
                'operativo'        => $registro->operativo ?? null,
                'marca_id'         => $registro->marca_id ?? null,
                'modelo_id'        => $registro->modelo_id ?? null,
                'motor_id'         => $registro->motor_id ?? null,
                'compania_id'      => $registro->compania_id ?? null,
                'operatividad_id'  => $registro->estado_id ?? null,
                'creadoPor'        => 10231,
                'actualizadoPor'   => 10231,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            // 2. Obtener los comentarios relacionados con el hidraulico original
            $comentarios = DB::table('materialescbvp.vt_comentarios_hidraulico')
                ->where('hidraulico_id', $registro->idhidraulicos_ficha)
                ->get();

            // 3. Insertar los comentarios con el nuevo ID del móvil
            foreach ($comentarios as $comentario) {
                DB::table('personalcbvp.MAT_hidraulicos_comentarios')->insert([
                    'comentario'       => $comentario->comentario ?? null,
                    'hidraulico_id'    => $nuevoIdHidraulico,
                    'accion_id'        => $comentario->accion_id ?? null,
                    'creadoPor'        => $comentario->usuario_alta_id ?? null,
                    'created_at'       => $comentario->fechahora ?? now(),
                    'updated_at'       => $comentario->updated_at ?? now(),
                ]);
            }

            // 4. Obtener todas las herramientas asociadas al hidraulico original
            $herramientas = DB::table('materialescbvp.vt_hidraulicos_tienen_herramientas')
                ->where('hidraulico_id', $registro->idhidraulicos_ficha)
                ->get();

            // 5. Insertar las herramientas en la nueva tabla
            foreach ($herramientas as $herramienta) {
                $nuevoIdHerramienta = DB::table('personalcbvp.MAT_hidraulicos_herr')->insertGetId([
                    'serie'            => $herramienta->serie ?? null,
                    'operativo'        => $herramienta->operativo ?? null,
                    'hidraulico_id'    => $nuevoIdHidraulico,
                    'marca_id'         => $herramienta->marca_id ?? null,
                    'modelo_id'        => $herramienta->modelo_id ?? null,
                    'motor_id'         => $herramienta->motor_id ?? null,
                    'tipo_id'          => $herramienta->tipo_id ?? null,
                    'operatividad_id' => $herramienta->estado_id ?? null,
                    'creadoPor'        => 10231,
                    'actualizadoPor'   => 10231,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);

                // 6. Obtener los comentarios relacionados con la herramienta original
                $comentariosHerramientas = DB::table('materialescbvp.vt_comentarios_herramientas')
                    ->where('herramienta_id', $herramienta->idhidraulicos_herramientas)
                    ->get();

                // 7. Insertar los comentarios de herramientas con el nuevo ID de la herramienta
                foreach ($comentariosHerramientas as $comentarioHerramienta) {
                    DB::table('personalcbvp.MAT_hidraulicos_herr_comentarios')->insert([
                        'comentario'       => $comentarioHerramienta->comentario ?? null,
                        'herramienta_id'   => $nuevoIdHerramienta,
                        'accion_id'        => $comentarioHerramienta->accion_id ?? null,
                        'creadoPor'        => $comentarioHerramienta->usuario_alta_id ?? null,
                        'created_at'       => $comentarioHerramienta->fechahora ?? now(),
                        'updated_at'       => now(),
                    ]);
                }
            }
        }

        $this->info("Importación finalizada. Total de Hidraulicos migrados: " . count($registros));
    }
}
