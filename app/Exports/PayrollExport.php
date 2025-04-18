<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PayrollExport implements FromArray, WithHeadings
{
    protected $payroll;

    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
    }

    public function headings(): array
    {
        return [
            'No.',
            'Empleado',
            'Cédula',
            'Salario',
            'Auxilio Transporte',
            'Días Trabajados',
            'Devengado',
            'Deducciones',
            'Neto a Pagar',
            'Firma'
        ];
    }

    public function array(): array
    {
        $data = [];
        foreach ($this->payroll->details as $i => $detail) {
            $devengado = $detail->items->where('type', 'earning')->sum('amount');
            $deducciones = $detail->items->where('type', 'deduction')->sum('amount');

            $data[] = [
                'No.' => $i + 1,
                'Empleado' => $detail->employee->name,
                'Cédula' => $detail->employee->document_identification,
                'Salario' => $detail->base_salary,
                'Auxilio Transporte' => $detail->employee->transport_aid ?? 0,
                'Días Trabajados' => $detail->days_worked,
                'Devengado' => $devengado,
                'Deducciones' => $deducciones,
                'Neto a Pagar' => $detail->net_salary,
                'Firma' => ''
            ];
        }

        return $data;
    }
}