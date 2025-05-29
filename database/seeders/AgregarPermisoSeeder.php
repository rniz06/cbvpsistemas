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
        $modulos = [
            [
                'modulo' => 'Material Mayor',
                'orden' => 5,
            ],
            [
                'modulo' => 'Material Menor',
                'orden' => 6,
            ],
            [
                'modulo' => 'Equipos Hidraulicos',
                'orden' => 7,
            ],
            [
                'modulo' => 'Conductores',
                'orden' => 8,
            ],
        ];

        foreach ($modulos as $modulo) {
            SysModulo::create($modulo);
        }


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

            'Material Mayor Transmision Listar',
            'Material Mayor Transmision Crear',
            'Material Mayor Transmision Editar',
            'Material Mayor Transmision Eliminar',
            'Material Mayor Transmision Cambiar Estado',

            'Material Mayor Ejes Listar',
            'Material Mayor Ejes Crear',
            'Material Mayor Ejes Editar',
            'Material Mayor Ejes Eliminar',
            'Material Mayor Ejes Cambiar Estado',

            'Material Mayor Combustibles Listar',
            'Material Mayor Combustibles Crear',
            'Material Mayor Combustibles Editar',
            'Material Mayor Combustibles Eliminar',
            'Material Mayor Combustibles Cambiar Estado',

            'Material Mayor Acronimos Listar',
            'Material Mayor Acronimos Crear',
            'Material Mayor Acronimos Editar',
            'Material Mayor Acronimos Eliminar',
            'Material Mayor Acronimos Cambiar Estado',

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

            'Material Menor Listar',
            'Material Menor Crear',
            'Material Menor Ver',
            'Material Menor Editar',
            'Material Menor Eliminar',
            'Material Menor Exportar Excel',
            'Material Menor Exportar Pdf',
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
