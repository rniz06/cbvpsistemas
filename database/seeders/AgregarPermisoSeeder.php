<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\SysModulo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgregarPermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $modulos = [
        //     [
        //         'modulo' => 'Material Mayor',
        //         'orden' => 5,
        //     ],
        //     [
        //         'modulo' => 'Material Menor',
        //         'orden' => 6,
        //     ],
        //     [
        //         'modulo' => 'Equipos Hidraulicos',
        //         'orden' => 7,
        //     ],
        //     [
        //         'modulo' => 'Conductores',
        //         'orden' => 8,
        //     ],
        // ];

        // foreach ($modulos as $modulo) {
        //     SysModulo::create($modulo);
        // }


        $permisos = [

            'Material Mayor Listar',
            'Material Mayor Crear',
            'Material Mayor Ver',
            'Material Mayor Editar',
            'Material Mayor Eliminar',
            'Material Mayor Ver Servicio',
            'Material Mayor Agregar Accion',
            'Material Mayor Exportar Excel',
            'Material Mayor Exportar Pdf',
            'Material Mayor Dar De Baja',
            'Material Mayor Cambiar de Compania',

            'Equipos Hidraulicos Listar',
            'Equipos Hidraulicos Crear',
            'Equipos Hidraulicos Ver',
            'Equipos Hidraulicos Editar',
            'Equipos Hidraulicos Eliminar',
            'Equipos Hidraulicos Agregar Herramienta',
            'Equipos Hidraulicos Herramienta Agregar Accion',
            'Equipos Hidraulicos Exportar Excel',
            'Equipos Hidraulicos Exportar Pdf',

            'Conductores Listar',
            'Conductores Crear',
            'Conductores Ver',
            'Conductores Editar',
            'Conductores Eliminar',
            'Conductores Exportar Excel',
            'Conductores Exportar Pdf',
        ];

        // Crear permisos y guardarlos en un array para luego asignarlos
        $permissions = [];
        foreach ($permisos as $permiso) {
            $permissions[] = Permission::create(['name' => $permiso]);
        }

        // Asignar todos los permisos al rol superAdmin
        $superAdminRole = Role::where('name', 'superAdmin')->first();

        if ($superAdminRole) {
            // Obtener solo los nombres de los permisos para asignar
            $permissionNames = array_column($permissions, 'name');
            $superAdminRole->givePermissionTo($permissionNames);
        }
    }
}
