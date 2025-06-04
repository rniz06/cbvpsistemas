<?php

namespace App\Console\Commands\GadmaMigracion\Parametros\Moviles;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Tipos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:moviles-tipos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra los datos de la tabla materialescbvp.moviles a personalcbvp.MAT_moviles_tipos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Iniciando importación de MAT_moviles_tipos...");

        // Obtener todos los registros de móviles de la tabla origen
        $registros = DB::table('materialescbvp.moviles')->get();

        foreach ($registros as $registro) {
            DB::table('personalcbvp.MAT_moviles_tipos')->insertGetId([
                'tipo'             => $registro->tipo ?? null,
                'descripcion'      => $registro->descripcion ?? null,
                'created_at'       => $registro->fecha_alta ?? null,
                'updated_at'       => now(),
            ]);
        }

        $this->info("Importación finalizada. Total de registros migrados: " . count($registros));
    }
}
