<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;  
use App\Models\Employee;
use App\Models\Company;
use App\Models\EmployeeCompany;
use App\Models\PayrollDetail;
use App\Services\PayrollCalculator;
use App\Models\PayrollDetailItem;

//Para exportar a pdf
use Barryvdh\DomPDF\Facade\Pdf;


class PayrollDetailController extends Controller
{
   
    //mostrar detalle de nómina
    public function show($id)
    {
        $detail = PayrollDetail::with([
            'employee',
            'payroll',
            'items'
        ])->findOrFail($id);
    
        return view('payrolls.payroll_details.show', compact('detail'));
    }

    //recalcular dias trabajados
    public function updateDays(Request $request, PayrollDetail $payrollDetail)
    {
        $request->validate([
            'days_worked' => 'required|integer|min:0|max:30',
        ]);

        $employee = $payrollDetail->employee;

        // Recalcular con nuevos días
        $calculo = PayrollCalculator::calcularParaEmpleado($employee, $request->days_worked);

        // 1. Actualizar el detalle
        $payrollDetail->update([
            'days_worked' => $request->days_worked,
            'total_earnings' => $calculo['total_earnings'],
            'total_deductions' => $calculo['total_deductions'],
            'net_salary' => $calculo['net_salary'],
        ]);

        // 2. Eliminar ítems automáticos previos (opcional, aquí borramos todos)
        PayrollDetailItem::where('payroll_detail_id', $payrollDetail->id)->delete();

        // 3. Insertar ítems nuevos
        foreach (array_merge($calculo['devengados'], $calculo['deducciones']) as $item) {
            PayrollDetailItem::create([
                'payroll_detail_id' => $payrollDetail->id,
                'concept_id' => null,
                'type' => $item['type'],
                'description' => $item['name'],
                'amount' => $item['amount'],
            ]);
        }

        return redirect()->route('payroll_details.show', $payrollDetail->id)
            ->with('success', 'Días trabajados actualizados y valores recalculados.');
    }

    //exportar a pdf
    public function exportPdf(PayrollDetail $detail)
    {
        $pdf = Pdf::loadView('reportes.nomina.desprendibles.pdf', compact('detail'));
        return $pdf->stream('colilla_' . $detail->employee->name . '.pdf');
    }

    
}
