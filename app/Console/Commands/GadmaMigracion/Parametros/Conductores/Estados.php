<?php

namespace App\Console\Commands\GadmaMigracion\Parametros\Conductores;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Estados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:conductores-estados';

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
        $this->info("Iniciando importación de MAT_conductores_estados...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('materialescbvp.conductores_estados')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.MAT_conductores_estados')->insert([
                'estado'           => $registro->estado ?? null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
