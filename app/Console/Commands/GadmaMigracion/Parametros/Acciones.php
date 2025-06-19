<?php

namespace App\Console\Commands\GadmaMigracion\Parametros;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Acciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:acciones';

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
        $this->info("Iniciando importación de MAT_moviles_transmision...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('materialescbvp.acciones')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.MAT_acciones')->insert([
                'accion'      => $registro->accion ?? null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
