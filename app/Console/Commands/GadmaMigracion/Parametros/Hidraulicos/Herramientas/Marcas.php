<?php

namespace App\Console\Commands\GadmaMigracion\Parametros\Hidraulicos\Herramientas;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Marcas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:hidraulicos-herramientas-marcas';

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
        $this->info("Iniciando importación de MAT_hidraulicos_marcas...");

        // Obtener todos los registros de móviles de la tabla origen
        $registros = DB::table('materialescbvp.hidraulicos_herr_marcas')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.MAT_hidraulicos_herr_marcas')->insert([
                'marca'            => $registro->marca ?? null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
