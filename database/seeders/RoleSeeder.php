<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrador', 'description' => 'Acceso total al sistema'],
            ['name' => 'Empleado', 'description' => 'Acceso a su nómina y tickets de sistemas'],
            ['name' => 'Cartera', 'description' => 'Gestión de la cartera y pagos'],
            ['name' => 'Recursos Humanos', 'description' => 'Gestión de empleados y nómina'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
       
    }
}
