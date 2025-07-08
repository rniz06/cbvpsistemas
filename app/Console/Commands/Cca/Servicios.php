<?php

namespace App\Console\Commands\Cca;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Servicios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cca:servicios';

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
        $this->info("Iniciando importación de CCA_servicios...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('emepy_bd.servicios')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.CCA_servicios')->insert([
                'servicio'               => $registro->servicio ?? null,
                'clasificacion_boolean'  => $registro->clasificacion_boolean ?? null,
                'created_at'             => now(),
                'updated_at'             => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
