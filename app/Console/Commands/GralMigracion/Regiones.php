<?php

namespace App\Console\Commands\GralMigracion;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Regiones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gral-migracion:regiones';

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
        $this->info("Iniciando importación de GRAL_regiones...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('emepy_bd.regiones')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.GRAL_regiones')->insert([
                'region'           => $registro->region ?? null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
