<?php

namespace App\Console\Commands\AlfaMigracion;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ServiciosEstados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alfa-migracion:servicios-estados';

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

        // Paso 1: Insertar los registros (con ID autogenerado)
            DB::statement("
                INSERT INTO personalcbvp.CCA_servicios_estados (estado, created_at, updated_at)
                SELECT 
                    estado,
                    NOW() as created_at,
                    NOW() as updated_at
                FROM emepy_bd.servicios_estados
            ");

            // Paso 2: Actualizar los IDs según el estado
            DB::statement("
                UPDATE personalcbvp.CCA_servicios_estados 
                SET id_servicio_estado = CASE 
                    WHEN estado = 'Inicializado' THEN 0
                    WHEN estado = 'Compañia despachada' THEN 1
                    WHEN estado = 'Móvil despachado' THEN 2
                    WHEN estado = 'Servicio Culminado' THEN 3
                END
                WHERE estado IN ('Inicializado', 'Compañia despachada', 'Móvil despachado', 'Servicio Culminado')
            ");
    }
}
