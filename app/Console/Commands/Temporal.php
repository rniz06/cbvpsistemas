<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Temporal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:temporal';

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
        $this->info("Importando Gadma...");
        Artisan::call('gadma:ejecutar-migracion');
        $this->info("Importando Datos generales...");
        Artisan::call('gral:ejecutar-migracion');
        $this->info("Importando Alfa...");
        Artisan::call('alfa:ejetutar-migracion');
    }
}
