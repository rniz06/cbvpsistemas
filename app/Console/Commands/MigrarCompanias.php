<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarCompanias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrar-companias';

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
        $this->info("Iniciando importación de regiones, departamentos, ciudades y companias...");

        DB::select(
            "INSERT INTO personalcbvp.GRAL_companias (
                id_compania, compania, ciudad_id, region_id, orden, created_at, updated_at
            )
            SELECT
                idcompanias, compania, ciudad_id, region_id, orden, NOW(), NOW()
            FROM
                emepy_bd.companias;"
        );
    }
}
