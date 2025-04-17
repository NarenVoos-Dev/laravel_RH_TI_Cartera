<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Earning;

class EarningSeeder extends Seeder
{
    public function run(): void
    {
        $earnings = [
            ['name' => 'Auxilio de transporte', 'default_value' => 140606, 'is_editable' => false, 'is_taxable' => false],
            ['name' => 'Horas extra diurna', 'default_value' => null, 'is_editable' => true, 'is_taxable' => true],
            ['name' => 'Horas extra nocturna', 'default_value' => null, 'is_editable' => true, 'is_taxable' => true],
            ['name' => 'Horas dominicales y festivas', 'default_value' => null, 'is_editable' => true, 'is_taxable' => true],
            ['name' => 'Recargo nocturno', 'default_value' => null, 'is_editable' => true, 'is_taxable' => true],
            ['name' => 'Bonificación', 'default_value' => null, 'is_editable' => true, 'is_taxable' => true],
        ];

        foreach ($earnings as $earning) {
            Earning::create($earning);
        }
    }
}