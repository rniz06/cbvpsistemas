<?php

namespace App\Console\Commands\GadmaMigracion;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class EjecutarMigracion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gadma:ejecutar-migracion';

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
        // Importando los datos generales
        $this->info("Importando los datos generales (Acciones, Estados, Operatividad)...");
        Artisan::call('gadma-migracion:acciones');
        Artisan::call('gadma-migracion:estados');
        Artisan::call('gadma-migracion:operatividad');

        // Importando los datos del modulo de Material Mayor
        $this->info("Importando los datos del modulo de Material Mayor...");
        Artisan::call('gadma-migracion:moviles-transmision');
        Artisan::call('gadma-migracion:moviles-tipos');
        Artisan::call('gadma-migracion:moviles-ejes');
        Artisan::call('gadma-migracion:moviles-marcas');
        Artisan::call('gadma-migracion:moviles-modelos');
        Artisan::call('gadma-migracion:moviles-combustibles');
        Artisan::call('app:importar-moviles-con-comentarios-desde-vista');

        // Importando los datos del modulo de Equipo Hidraulico y Herramientas
        $this->info("Importando los datos del modulo de Equipo Hidraulico y Herramientas...");
        Artisan::call('gadma-migracion:hidraulicos-motor');
        Artisan::call('gadma-migracion:hidraulicos-marcas');
        Artisan::call('gadma-migracion:hidraulicos-modelos');

        Artisan::call('gadma-migracion:hidraulicos-herramientas-marcas');
        Artisan::call('gadma-migracion:hidraulicos-herramientas-modelos');
        Artisan::call('gadma-migracion:hidraulicos-herramientas-motor');
        Artisan::call('gadma-migracion:hidraulicos-herramientas-tipos');
        Artisan::call('app:importar-hidraulicos-con-comentarios-desde-vista');

        // Importando los datos del modulo conductores
        $this->info("Importando los datos del modulo de conductores...");
        Artisan::call('gadma-migracion:conductores-tipo-vehiculo');
        Artisan::call('gadma-migracion:conductores-estados');
        Artisan::call('gadma-migracion:conductores-clase-licencias');
        Artisan::call('gadma-migracion:conductores-bomberos');
    }
}
