<?php

namespace App\Console\Commands\GadmaMigracion\Parametros\Moviles;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Transmision extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:moviles-transmision';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra los datos de la tabla materialescbvp.moviles_transmision a personalcbvp.MAT_moviles_transimision';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Iniciando importación de MAT_moviles_transmision...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('materialescbvp.moviles_transmision')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.MAT_moviles_transmision')->insert([
                'transmision'      => $registro->transmision ?? null,
                'activo'           => 1, // Activo
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
