<?php

namespace App\Console\Commands\AlfaMigracion;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class EjetutarMigracion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alfa:ejetutar-migracion';

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
        $this->info("Importando los datos generales (Estados, Servicios, Clasificaciones)...");
        Artisan::call('alfa-migracion:servicios-estados');
        Artisan::call('alfa-migracion:servicios');
        Artisan::call('alfa-migracion:servicios-clasificaciones');
        //Artisan::call('alfa-migracion:servicios-existentes');
        //Artisan::call('alfa-migracion:servicios');
    }
}
