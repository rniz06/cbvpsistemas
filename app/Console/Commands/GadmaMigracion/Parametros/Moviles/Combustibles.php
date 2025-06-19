<?php

namespace App\Console\Commands\GadmaMigracion\Parametros\Moviles;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Combustibles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:moviles-combustibles';

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
        $this->info("Iniciando importación de MAT_moviles_combustibles...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('materialescbvp.moviles_combustible')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.MAT_moviles_combustibles')->insert([
                'tipo'             => $registro->tipo ?? null,
                'activo'           => 1, // Activo
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
