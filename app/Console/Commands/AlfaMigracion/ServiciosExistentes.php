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

        // Obtener todos los registros de servicios_existentes de la tabla origen
        $registros = DB::table('emepy_bd.servicios_existentes')->get();

        foreach ($registros as $registro) {

            $nuevoIdMovil = DB::table('personalcbvp.MAT_moviles_id_map')
                ->where('old_id', $registro->movil_id)
                ->value('new_id');

            // 1. Insertar el servicios_existentes en la nueva tabla y obtener el ID generado
            $nuevoIdServicio = DB::table('personalcbvp.CCA_servicios_existentes')->insertGetId([
                'compania_id'           => $registro->compania_id ?? null,
                'servicio_id'           => $registro->servicio_id ?? null,
                'clasificacion_id'      => $registro->clasificacion_id ?? null,
                'informacion_servicio'  => $registro->informacion_servicio ?? null,
                'ciudad_id'             => $registro->ciudad_id ?? null,
                'calle_referencia'      => $registro->calle_referencia ?? null,
                'movil_id'              => $nuevoIdMovil ?? null,
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

            // 2. Obtener los apoyos relacionados con el servicio original
            $apoyos = DB::table('emepy_bd.servicios_existentes_apoyos')
                ->where('servicio_id', $registro->idservicios_existentes)
                ->get();

            // 3. Insertar los apoyos con el nuevo ID del servicio
            foreach ($apoyos as $apoyo) {
                DB::table('personalcbvp.CCA_servicios_existentes_apoyos')->insert([
                    'cantidad_tripulantes'  => $apoyo->tripulantes ?? null,
                    'servicio_id'           => $nuevoIdServicio, // Usamos el nuevo ID generado
                    'compania_id'           => $apoyo->compania_id ?? null,
                    'movil_id'              => $nuevoIdMovil ?? null,
                    'acargo'                => null,
                    'chofer'                => null,
                    'fecha_cia'             => $apoyo->fecha_cia ?? null,
                    'fecha_movil'           => $apoyo->fecha_movil ?? null,
                    'fecha_servicio'        => $apoyo->fecha_servicio ?? null,
                    'fecha_base'            => $apoyo->fecha_base ?? null,
                    'acargo_old'            => $apoyo->acargo ?? null,
                    'chofer_old'            => $apoyo->chofer ?? null,
                    'creadoPor'             => 10231,
                    'actualizadoPor'        => 10231,
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ]);
            }

            // 4. Obtener los comentarios relacionados con el servicio original
            $comentarios = DB::table('emepy_bd.servicios_existentes_comentarios')
                ->where('servicio_id', $registro->idservicios_existentes)
                ->get();

            // 5. Insertar los comentarios con el nuevo ID del servicio
            foreach ($comentarios as $comentario) {
                DB::table('personalcbvp.CCA_servicios_existentes_comentarios')->insert([
                    'comentario'       => $comentario->comentario ?? null,
                    'servicio_id'      => $nuevoIdServicio, // Usamos el nuevo ID generado
                    'creadoPor'        => 10231,
                    'actualizadoPor'   => 10231,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }
}
