<?php

namespace App\Console\Commands\GadmaMigracion\Parametros\Moviles;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Modelos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:moviles-modelos';

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
        $this->info("Iniciando importación de MAT_moviles_modelos...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('materialescbvp.moviles_modelos')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.MAT_moviles_modelos')->insert([
                'modelo'           => $registro->modelo ?? null,
                'marca_id'         => $registro->marca_id ?? null,
                'activo'           => 1, // Activo
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
