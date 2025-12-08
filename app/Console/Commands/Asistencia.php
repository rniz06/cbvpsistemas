<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use App\Models\SysSubModulo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Asistencia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:asistencia';

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

        Artisan::call('migrate');

        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\Gral\\AnhoSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\Gral\\MesSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\Personal\\Asistencia\\EstadoSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\Personal\\Asistencia\\PeriodoSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\Personal\\Asistencia\\AsistenciaSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\Personal\\Asistencia\\DetalleSeeder']);

        $sub_modulo = SysSubModulo::create([
            'sub_modulo' => 'Asistencias',
            'modulo_id' => 1
        ]);

        $permisos = [
            'Personal Asistencias Listar',
            'Personal Asistencias Ver',
            'Personal Asistencias Enviar a Dpto de Personal',
            'Personal Asistencias Aprobar',
            'Personal Asistencias Rechazar y derivar a la Compania',
            'Personal Asistencias Habilitar Citacion',
            'Personal Asistencias Exportar Pdf',
            'Personal Asistencias Carga'
        ];

        foreach ($permisos as $permiso) {
            Permission::create([
                'name' => $permiso,
                'modulo_id' => 1, // Modulo: Personal
                'sub_modulo_id' => $sub_modulo->id_sub_modulo
            ]);
        }

    }
}
