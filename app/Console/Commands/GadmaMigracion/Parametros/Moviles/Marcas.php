<?php

namespace App\Console\Commands\GadmaMigracion\Parametros\Moviles;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Marcas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:moviles-marcas';

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
        $this->info("Iniciando importación de MAT_moviles_marcas...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('materialescbvp.moviles_marca')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.MAT_moviles_marcas')->insert([
                'marca'            => $registro->marca ?? null,
                'activo'           => 1, // Activo
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
