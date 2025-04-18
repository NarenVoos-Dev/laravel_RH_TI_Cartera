<?php

namespace App\Http\Controllers;
use App\Models\PayrollDetail;
use App\Models\PayrollDetailItem;
use App\Models\Earning;
use App\Models\Deduction;

use Illuminate\Http\Request;

class PayrollDetailItemController extends Controller
{
    
    public function index()
    {
        //
    }

 
    public function create()
    {
        //
    }
    //agregar concepto manual
    public function store(Request $request, PayrollDetail $detail)
    {
        $request->validate([
            'type' => 'required|in:earning,deduction',
            'concept_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);
    
        $conceptId = null;
    
        if ($request->type === 'earning') {
            $concept = Earning::firstOrCreate(
                ['name' => $request->concept_name],
                ['default_value' => $request->amount, 'is_editable' => true, 'is_taxable' => true]
            );
            $conceptId = $concept->id;
        }
    
        if ($request->type === 'deduction') {
            $concept = Deduction::firstOrCreate(
                ['name' => $request->concept_name],
                ['percentage' => null, 'is_mandatory' => false, 'is_editable' => true]
            );
            $conceptId = $concept->id;
        }
    
        PayrollDetailItem::create([
            'payroll_detail_id' => $detail->id,
            'type' => $request->type,
            'description' => $request->concept_name,
            'amount' => $request->amount,
            'concept_id' => $conceptId,
        ]);
    
        // Recalcular totales
        $totalEarnings = $detail->items()->where('type', 'earning')->sum('amount');
        $totalDeductions = $detail->items()->where('type', 'deduction')->sum('amount');
        $netSalary = $totalEarnings - $totalDeductions;
    
        $detail->update([
            'total_earnings' => $totalEarnings,
            'total_deductions' => $totalDeductions,
            'net_salary' => $netSalary,
        ]);
    
        return redirect()->route('payroll_details.show', $detail->id)
            ->with('success', 'Concepto agregado correctamente.');
    }
    


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(PayrollDetailItem $item)
    {
        $payrollDetail = $item->payrollDetail;
    
        $item->delete();
    
        // Solo si se pudo cargar el detalle
        if ($payrollDetail) {
            // Recalcular totales
            $totalEarnings = $payrollDetail->items()->where('type', 'earning')->sum('amount');
            $totalDeductions = $payrollDetail->items()->where('type', 'deduction')->sum('amount');
            $netSalary = $totalEarnings - $totalDeductions;
    
            $payrollDetail->update([
                'total_earnings' => $totalEarnings,
                'total_deductions' => $totalDeductions,
                'net_salary' => $netSalary,
            ]);
        }
    
        return redirect()->route('payroll_details.show', $item->payroll_detail_id)
            ->with('success', 'Concepto eliminado correctamente.');
    }
    
}
