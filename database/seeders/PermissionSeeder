<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
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

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }
    }
}
