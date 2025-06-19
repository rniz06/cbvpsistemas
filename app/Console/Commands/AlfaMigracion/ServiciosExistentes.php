<?php

namespace App\Console\Commands\AlfaMigracion;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ServiciosExistentes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alfa-migracion:servicios-existentes';

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

        // Desactivar logging de queries para mejorar el rendimiento
        DB::disableQueryLog();

        // Precargar el mapa de móviles para evitar consultas por cada servicio
        $mapaMoviles = DB::table('personalcbvp.MAT_moviles_id_map')
            ->pluck('new_id', 'old_id'); // [old_id => new_id]

        // Procesar por lotes para ahorrar memoria
        DB::table('emepy_bd.servicios_existentes')->orderBy('idservicios_existentes')->chunk(1000, function ($registros) use ($mapaMoviles) {

            foreach ($registros as $registro) {
                $nuevoIdMovil = $mapaMoviles[$registro->movil_id] ?? null;

                // Insertar servicio
                $nuevoIdServicio = DB::table('personalcbvp.CCA_servicios_existentes')->insertGetId([
                    'compania_id'           => $registro->compania_id ?? null,
                    'servicio_id'           => $registro->servicio_id ?? null,
                    'clasificacion_id'      => $registro->clasificacion_id ?? null,
                    'informacion_servicio'  => $registro->informacion_servicio ?? null,
                    'ciudad_id'             => $registro->ciudad_id ?? null,
                    'calle_referencia'      => $registro->calle_referencia ?? null,
                    'movil_id'              => $nuevoIdMovil,
                    'acargo'                => null,
                    'chofer'                => null,
                    'estado_id'             => $registro->estado_servicio ?? null,
                    'cantidad_tripulantes'  => $registro->tripulantes ?? null,
                    'fecha_alfa'            => $registro->fecha_alfa ?? null,
                    'fecha_cia'             => $registro->fecha_cia ?? null,
                    'fecha_movil'           => $registro->fecha_movil ?? null,
                    'fecha_servicio'        => $registro->fecha_servicio ?? null,
                    'fecha_base'            => $registro->fecha_base ?? null,
                    'falsa_alarma'          => $registro->falsa_alarma ?? null,
                    'acargo_old'            => $registro->acargo ?? null,
                    'chofer_old'            => $registro->chofer ?? null,
                    'creadoPor'             => null,
                    'actualizadoPor'        => null,
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ]);

                // --- Apoyos relacionados ---
                $apoyos = DB::table('emepy_bd.servicios_existentes_apoyos')
                    ->where('servicio_id', $registro->idservicios_existentes)
                    ->get();

                $apoyosBulk = [];

                foreach ($apoyos as $apoyo) {
                    $apoyosBulk[] = [
                        'cantidad_tripulantes' => $apoyo->tripulantes ?? null,
                        'servicio_id'          => $nuevoIdServicio,
                        'compania_id'          => $apoyo->compania_id ?? null,
                        'movil_id'             => $nuevoIdMovil,
                        'acargo'               => null,
                        'chofer'               => null,
                        'fecha_cia'            => $apoyo->fecha_cia ?? null,
                        'fecha_movil'          => $apoyo->fecha_movil ?? null,
                        'fecha_servicio'       => $apoyo->fecha_servicio ?? null,
                        'fecha_base'           => $apoyo->fecha_base ?? null,
                        'acargo_old'           => $apoyo->acargo ?? null,
                        'chofer_old'           => $apoyo->chofer ?? null,
                        'creadoPor'            => 10231,
                        'actualizadoPor'       => 10231,
                        'created_at'           => now(),
                        'updated_at'           => now(),
                    ];
                }

                if (!empty($apoyosBulk)) {
                    DB::table('personalcbvp.CCA_servicios_existentes_apoyos')->insert($apoyosBulk);
                }

                // --- Comentarios relacionados ---
                $comentarios = DB::table('emepy_bd.servicios_existentes_comentarios')
                    ->where('servicio_id', $registro->idservicios_existentes)
                    ->get();

                $comentariosBulk = [];

                foreach ($comentarios as $comentario) {
                    $comentariosBulk[] = [
                        'comentario'      => $comentario->comentario ?? null,
                        'servicio_id'     => $nuevoIdServicio,
                        'creadoPor'       => 10231,
                        'actualizadoPor'  => 10231,
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ];
                }

                if (!empty($comentariosBulk)) {
                    DB::table('personalcbvp.CCA_servicios_existentes_comentarios')->insert($comentariosBulk);
                }
            }

            $this->info("Lote procesado...");
        });

        $this->info("Migración finalizada con éxito.");
    }
}
