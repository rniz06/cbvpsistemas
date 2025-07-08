<?php

namespace App\Console\Commands\Cca;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class EjecutarMigracion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cca:ejecutar-migracion';

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
        $this->info("Importando los datos generales de CCA (Servicios, Clasificaciones, Estados)...");
        Artisan::call('cca:servicios');
        Artisan::call('cca:servicios-clasificaciones');
        Artisan::call('cca:servicios-estados');
        $this->info("Importacion finalizada...");
    }
}
