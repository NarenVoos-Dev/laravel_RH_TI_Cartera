<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   
    public function run()
    {
        DB::beginTransaction();
        try {
            // 1️⃣ Crear un usuario
            $user = User::create([
                'name' => 'Empleado de Prueba',
                'username' => 'empleado1',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Asegúrate de que este rol exista
                'status' => 'active',
            ]);

            // 2️⃣ Crear un empleado asociado al usuario
            $employee = Employee::create([
                'user_id' => $user->id,
                'document_identification' => '123456789',
                'salary' => 2500000,
                'transport_aid' => 200000,
                'hire_date' => now(),
                'status' => 'active',
            ]);

            // 3️⃣ Asignar el empleado a una empresa
            $company = Company::first(); // Toma la primera empresa existente
            if (!$company) {
                $company = Company::create([
                    'name' => 'Empresa de Prueba',
                    'nit' => '900123456-7',
                    'address' => 'Calle Falsa 123',
                    'phone' => '3001234567',
                    'email' => 'empresa@prueba.com',
                    'status' => 1,
                ]);
            }

            DB::table('employee_company')->insert([
                'employee_id' => $employee->id,
                'company_id' => $company->id,
                'assigned_at' => now(),
                'removed_at' => null, // Aún sigue en la empresa
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            echo "✅ Empleado de prueba creado exitosamente.\n";
        } catch (\Exception $e) {
            DB::rollBack();
            echo "❌ Error al crear el empleado: " . $e->getMessage() . "\n";
        }
    }
}
