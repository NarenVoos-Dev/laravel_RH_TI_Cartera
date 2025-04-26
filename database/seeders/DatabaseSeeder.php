<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;




class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
           // 'name' => 'Test User',
            //'email' => 'test@example.com',
        //]);
        //Crear roles y permisos
        //$this->call(RoleSeeder::class);
        //$this->call([ RolesAndPermissionsSeeder::class,]);
        // Crear usuarios solo admin
        //$this->call(UserSeeder::class);
        //$this->call(CompanySeeder::class);

        // deduciones y devengados basicos    
        //$this->call([EarningSeeder::class, DeductionSeeder::class,]);
        
        //crear permisos nuevos 
        $this->call([PermissionSeeder::class,]);
    }
}
