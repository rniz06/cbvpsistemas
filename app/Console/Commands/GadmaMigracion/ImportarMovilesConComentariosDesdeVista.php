<?php

namespace App\Console\Commands\GadmaMigracion;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportarMovilesConComentariosDesdeVista extends Command
{
    /**
     * Importa datos de la vista materialescbvp.vt_companias_tienen_moviles
     * a personalcbvp.MAT_moviles obteniendo tambien los comentarios relacionados
     * a cada registro de la vista desde materialescbvp.vt_comentarios_mayor e irnsentandolos
     * en la tabla personalcbvp.MAT_moviles_comentarios con los nuevos ids.
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:importar-moviles-con-comentarios-desde-vista';

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

        // Obtener todos los registros de móviles de la tabla origen
        $registros = DB::table('materialescbvp.vt_companias_tienen_moviles')->get();

        foreach ($registros as $registro) {
            // 1. Insertar el móvil en la nueva tabla y obtener el ID generado
            $nuevoIdMovil = DB::table('personalcbvp.MAT_moviles')->insertGetId([
                'chasis'           => $registro->chasis ?? null,
                'detalles'         => $registro->detalles ?? null,
                'operativo'        => $registro->operativo ?? null,
                'anho'             => $registro->ano ?? null,
                'cubiertas_frente' => $registro->cubiertas_frent ?? null,
                'cubiertas_atras'  => $registro->cubiertas_atras ?? null,
                'chapa'            => $registro->chapa ?? null,
                'movil_tipo_id'    => $registro->movil_id ?? null,
                'marca_id'         => $registro->marca_id ?? null,
                'modelo_id'        => $registro->modelo_id ?? null,
                'transmision_id'   => $registro->transmision_id ?? null,
                'eje_id'           => $registro->ejes_id ?? null,
                'combustible_id'   => $registro->combustible_id ?? null,
                'operatividad_id'  => $registro->estado_id ?? null,
                'compania_id'      => $registro->compania_id ?? null,
                'creadoPor'        => 10231,
                'actualizadoPor'   => 10231,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            // 2. Obtener los comentarios relacionados con el móvil original
            $comentarios = DB::table('materialescbvp.vt_comentarios_mayor')
                ->where('movil_id', $registro->idmoviles_ficha)
                ->get();

            // 3. Insertar los comentarios con el nuevo ID del móvil
            foreach ($comentarios as $comentario) {
                DB::table('personalcbvp.MAT_moviles_comentarios')->insert([
                    'comentario'  => $comentario->comentario ?? null,
                    'movil_id'    => $nuevoIdMovil, // Usamos el nuevo ID generado
                    'accion_id'   => $comentario->accion_id ?? null,
                    'creadoPor'   => $comentario->usuario_alta_id ?? null,
                    'created_at'  => $comentario->fechahora ?? now(),
                    'updated_at'  => $comentario->updated_at ?? now(),
                ]);
            }
        }

        $this->info("Importación finalizada. Total de móviles migrados: " . count($registros));
    }
}
