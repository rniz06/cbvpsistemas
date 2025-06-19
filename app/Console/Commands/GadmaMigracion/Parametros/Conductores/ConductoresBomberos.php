<?php

namespace App\Console\Commands\GadmaMigracion\Parametros\Conductores;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConductoresBomberos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:conductores-bomberos';

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
        $this->info("Iniciando importación de MAT_conductores_bomberos...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('materialescbvp.vt_conductores')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.MAT_conductores_bomberos')->insert([
                'personal_id'           => $registro->personal_id ?? null,
                'estado_id'             => $registro->estado_id ?? null,
                'resolucion'            => $registro->resolucion ?? null,
                'resolucion_enlace'     => null,
                'fecha_curso'           => $registro->fecha_curso ?? null,
                'ciudad_curso_id'       => $registro->ciudad_curso_id ?? null,
                'ciudad_licencia_id'    => $registro->ciudad_licencia_id ?? null,
                'clase_licencia_id'     => $registro->clase_licencia_id ?? null,
                'tipo_vehiculo_id'      => $registro->tipo_vehiculo_id ?? null,
                'numero_licencia'       => $registro->numero_licencia ?? null,
                'creadoPor'             => $registro->usuario_alta_id ?? null,
                'created_at'            => $registro->fecha_alta ?? null,
                'updated_at'            => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
