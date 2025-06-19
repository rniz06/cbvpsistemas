<?php

namespace App\Console\Commands\GadmaMigracion\Parametros\Conductores;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TipoVehiculo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:conductores-tipo-vehiculo';

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
        $this->info("Iniciando importación de MAT_conductores_tipo_vehiculo...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('materialescbvp.conductores_tipo_vehiculo')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.MAT_conductores_tipo_vehiculo')->insert([
                'tipo'             => $registro->tipo ?? null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
