<?php

namespace App\Services;

use App\Models\Employee;

class PayrollCalculator
{
    const SMMLV = 1423500; // Salario mínimo legal vigente 2025
    const AUXILIO_TRANSPORTE = 200000; //auxilio de transporte

    public static function calcularParaEmpleado(Employee $employee, int $diasTrabajados = 15): array
    {
        // Cálculo salario proporcional
        $salarioMensual = $employee->salary ?? 0;
        $salarioDiario = $salarioMensual / 30;
        $salarioDevengado = round($salarioDiario * $diasTrabajados, 0);

        // Auxilio transporte (solo si salario mensual ≤ 2 SMMLV)
        $auxilio = 0;
        if ($salarioMensual <= (2 * self::SMMLV)) {
            $auxilio = $employee->transport_aid ?? self::AUXILIO_TRANSPORTE;
        }

        // Deducciones
        $deducciones = [];
        $totalDeducciones = 0;

        // Salud 4%
        $salud = round($salarioDevengado * 0.04, 0);
        $deducciones[] = [
            'name' => 'Salud (4%)',
            'type' => 'deduction',
            'amount' => $salud,
        ];
        $totalDeducciones += $salud;

        // Pensión 4%
        $pension = round($salarioDevengado * 0.04, 0);
        $deducciones[] = [
            'name' => 'Pensión (4%)',
            'type' => 'deduction',
            'amount' => $pension,
        ];
        $totalDeducciones += $pension;

        // Si gana más de 4 SMMLV → aplicar fondos
        if ($salarioMensual >= (4 * self::SMMLV)) {
            $solidaridad = round($salarioDevengado * 0.005, 0);
            $subsistencia = round($salarioDevengado * 0.005, 0);

            $deducciones[] = [
                'name' => 'Fondo de Solidaridad (0.5%)',
                'type' => 'deduction',
                'amount' => $solidaridad,
            ];

            $deducciones[] = [
                'name' => 'Fondo de Subsistencia (0.5%)',
                'type' => 'deduction',
                'amount' => $subsistencia,
            ];

            $totalDeducciones += $solidaridad + $subsistencia;
        }

        $devengados = [
            [
                'name' => 'Salario proporcional',
                'type' => 'earning',
                'amount' => $salarioDevengado,
            ],
        ];

        if ($auxilio > 0) {
            $devengados[] = [
                'name' => 'Auxilio de transporte',
                'type' => 'earning',
                'amount' => $auxilio,
            ];
        }

        $totalDevengado = $salarioDevengado + $auxilio;
        $neto = $totalDevengado - $totalDeducciones;

        return [
            'devengados' => $devengados,
            'deducciones' => $deducciones,
            'total_earnings' => $totalDevengado,
            'total_deductions' => $totalDeducciones,
            'net_salary' => $neto,
        ];
    }
}
