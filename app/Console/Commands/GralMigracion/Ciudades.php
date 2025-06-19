<?php

namespace App\Console\Commands\GralMigracion;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Ciudades extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gral-migracion:ciudades';

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
        $this->info("Iniciando importación de GRAL_ciudades...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('emepy_bd.ciudades')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.GRAL_ciudades')->insert([
                'ciudad'           => $registro->ciudad ?? null,
                'departamento_id'  => $registro->departamento_id ?? null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
