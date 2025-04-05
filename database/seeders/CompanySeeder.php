<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;


class CompanySeeder extends Seeder
{
    
    public function run(): void
    {
        {
            Company::create([
                'name' => 'Empresa de Prueba',
                'nit' => '900123456',
                'address' => 'Calle Falsa 123',
                'phone' => '1234567890',
                'email' => 'contacto@empresa.com',
                'status' => 1
            ]);
        }
    }
}
