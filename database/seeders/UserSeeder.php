<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegúrate de que el rol exista
        $adminRole = Role::firstOrCreate([
            'name' => 'administrador',
            'guard_name' => 'web'
        ]);

        // Crear usuario administrador
        $user = User::create([
            'name' => 'Administrador',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id, // Este es solo visual si lo usas
            'status' => 'active',
        ]);

        // 👉 Asignar el rol con Spatie
        $user->assignRole('administrador');
    }
}
