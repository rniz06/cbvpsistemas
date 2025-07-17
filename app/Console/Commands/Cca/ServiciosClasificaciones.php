<?php

namespace App\Console\Commands\Cca;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ServiciosClasificaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cca:servicios-clasificaciones';

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
        $this->info("Iniciando importación de CCA_servicios_clasificaciones...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('emepy_bd.servicios_clasificacion')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.CCA_servicios_clasificaciones')->insert([
                'clasificacion'          => $registro->clasificacion ?? null,
                'servicio_id'            => $registro->servicio_id ?? null,
                'created_at'             => now(),
                'updated_at'             => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
