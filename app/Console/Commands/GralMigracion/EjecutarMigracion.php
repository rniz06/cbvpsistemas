<?php

namespace App\Console\Commands\GralMigracion;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class EjecutarMigracion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gral:ejecutar-migracion';

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
        $this->info("Importando los datos generales (Regiones, Departamentos, Ciudades, Companias)...");
        Artisan::call('gral-migracion:regiones');
        Artisan::call('gral-migracion:departamentos');
        Artisan::call('gral-migracion:ciudades');
        Artisan::call('gral-migracion:companias');
    }
}
