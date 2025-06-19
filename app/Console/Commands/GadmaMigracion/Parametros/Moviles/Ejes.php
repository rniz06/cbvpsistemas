<?php

namespace App\Console\Commands\GadmaMigracion\Parametros\Moviles;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Ejes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:moviles-ejes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra los datos de la tabla materialescbvp.moviles_ejes a personalcbvp.MAT_moviles_ejes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Iniciando importación de MAT_moviles_transmision...");

        // Obtener todos los registros de móviles de la tabla origen
        $registros = DB::table('materialescbvp.moviles_ejes')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.MAT_moviles_ejes')->insert([
                'eje'              => $registro->eje ?? null,
                'activo'           => 1, // Activo
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
