<?php

namespace App\Console\Commands\GralMigracion;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Companias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gral-migracion:companias';

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
        $this->info("Iniciando importación de GRAL_companias...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('emepy_bd.companias')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.GRAL_companias')->insert([
                'compania'         => $registro->compania ?? null,
                'ciudad_id'        => $registro->ciudad_id ?? null,
                'region_id'        => $registro->region_id ?? null,
                'orden'            => $registro->orden ?? null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
