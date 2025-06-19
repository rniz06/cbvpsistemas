<?php

namespace App\Console\Commands\GadmaMigracion\Parametros;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Estados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma-migracion:estados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * SE EJECUTA CON CODIGO SQL DEBIDO A QUE UN REGISTRO CUENTA CON ID 0.
     */
    public function handle()
    {
        $this->info("Iniciando importación de MAT_estados...");

            // Paso 1: Insertar los registros (con ID autogenerado)
            DB::statement("
                INSERT INTO personalcbvp.MAT_estados (estado, created_at, updated_at)
                SELECT 
                    estado,
                    NOW() as created_at,
                    NOW() as updated_at
                FROM materialescbvp.estados
            ");

            // Paso 2: Actualizar los IDs según el estado
            DB::statement("
                UPDATE personalcbvp.MAT_estados 
                SET id_estado = CASE 
                    WHEN estado = 'INACTIVO' THEN 0
                    WHEN estado = 'ACTIVO' THEN 1
                END
                WHERE estado IN ('INACTIVO', 'ACTIVO')
            ");

        $this->info("Importación finalizada. Total de registros migrados: ");
    }
}
