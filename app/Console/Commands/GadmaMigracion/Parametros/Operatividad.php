<?php

namespace App\Console\Commands\GadmaMigracion\Parametros;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Operatividad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:operatividad';

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
        // Paso 1: Insertar los registros (con ID autogenerado)
            DB::statement("
                INSERT INTO personalcbvp.MAT_operatividad (operatividad, created_at, updated_at)
                SELECT 
                    estado,
                    NOW() as created_at,
                    NOW() as updated_at
                FROM materialescbvp.operatividad
            ");

            // Paso 2: Actualizar los IDs según el estado
            DB::statement("
                UPDATE personalcbvp.MAT_operatividad 
                SET id_operatividad = CASE 
                    WHEN operatividad = 'INOPERATIVO' THEN 0
                    WHEN operatividad = 'OPERATIVO' THEN 1
                    WHEN operatividad = 'BAJA' THEN 2
                END
                WHERE operatividad IN ('INOPERATIVO', 'OPERATIVO', 'BAJA')
            ");
    }
}
