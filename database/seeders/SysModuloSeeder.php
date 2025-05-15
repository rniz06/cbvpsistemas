<?php

namespace Database\Seeders;

use App\Models\SysModulo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SysModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modulos = [
            [
                'modulo' => 'Personal',
                'descripcion' => 'Gestión de datos del Personal Voluntario',
                'orden' => 1,
            ],
            [
                'modulo' => 'Usuarios',
                'descripcion' => 'Gestión de usuarios del sistema',
                'orden' => 2,
            ],
            [
                'modulo' => 'Roles',
                'descripcion' => 'Gestión de roles del sistema (ABM y asignación de permisos a roles)',
                'orden' => 3,
            ],
            [
                'modulo' => 'Permisos',
                'descripcion' => 'Asignación de permisos específicos o individuales a usuarios',
                'orden' => 4,
            ],
        ];

        foreach ($modulos as $modulo) {
            SysModulo::create($modulo);
        }
    }
}
