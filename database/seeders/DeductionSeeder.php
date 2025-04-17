<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Deduction;;

class DeductionSeeder extends Seeder
{
    public function run(): void
    {
        $deductions = [
            ['name' => 'Salud', 'percentage' => 4.00, 'is_mandatory' => true, 'is_editable' => false],
            ['name' => 'Pensión', 'percentage' => 4.00, 'is_mandatory' => true, 'is_editable' => false],
            ['name' => 'Fondo de solidaridad', 'percentage' => 0.50, 'is_mandatory' => true, 'is_editable' => false],
            ['name' => 'Fondo de subsistencia', 'percentage' => 0.50, 'is_mandatory' => true, 'is_editable' => false],
            ['name' => 'Préstamo', 'percentage' => null, 'is_mandatory' => false, 'is_editable' => true],
            ['name' => 'Libranza', 'percentage' => null, 'is_mandatory' => false, 'is_editable' => true],
        ];

        foreach ($deductions as $deduction) {
            Deduction::create($deduction);
        }
    }
}

