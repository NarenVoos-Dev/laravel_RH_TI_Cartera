<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos base
        $permisos = [
            'cartera',
            'nomina',
            'empleados',
            'desprendibles',
            'configuracion',
            'asignaciones',
            'reportes',
            'tickets',
            // Módulo Cartera
            'crear cartera',
            'ver cartera',
            //'editar cartera',

            // Módulo Nómina
            'ver nomina',
            'crear nomina',
            'cerrar nomina',
            'crear abonos',
            //'confirmar nomina',

            // Módulo Desprendibles
            'ver colillas',

            // Módulo Empleados
            'gestionar empleados',
            'asignar asignaciones',

            // Módulo Roles y Usuarios
            'ver roles',
            'crear roles',
            'ver usuarios',
            'crear usuarios',
            'asignar permisos',

            // Módulo Configuraciones
            'ver configuracion',

            //companias
            'crear companías',
            'editar companías',
            'ver companías',
            

            // Módulo Reportes
            'ver reportes',

            //Dashboard
            'ver indicadores',

            // IT / Soporte
            'ver tickets',
            'crear tickets',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web',
            ]);
        }

        // Crear solo el rol admin (otros se crean desde la app)
        $admin = Role::firstOrCreate(['name' => 'administrador', 'guard_name' => 'web']);

        // Asignar todos los permisos al admin
        $admin->syncPermissions(Permission::all());
    }
}
