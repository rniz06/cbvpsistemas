<?php

namespace App\Console\Commands\Cca;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ServiciosEstados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cca:servicios-estados';

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
        $this->info("Iniciando importación de CCA_servicios_estados...");

        // Obtener todos los registros de la tabla origen
        $registros = DB::table('emepy_bd.servicios_estados')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.CCA_servicios_estados')->insert([
                'estado'                 => $registro->estado ?? null,
                'created_at'             => now(),
                'updated_at'             => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
