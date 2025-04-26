<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Models\Company;
use App\Models\EmployeeCompany;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\PayrollDetailItem;
use App\Services\PayrollCalculator;

//exportar excel
use App\Exports\PayrollExport;
use Maatwebsite\Excel\Facades\Excel;

class PayrollsController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('company')->latest()->get();
        $companies = Company::all();
        return view('payrolls.index', compact('payrolls','companies'));
    }
    public function create()
    {
        $companies = Company::all()->where('type', 'interna');
        return view('payrolls.create', compact('companies'));
    }
    
    public function show($id)
    {
        $payroll = Payroll::with([
            'company',
            'details.employee'
        ])->findOrFail($id);
    
        return view('payrolls.show', compact('payroll'));
    }

    //crear nómina
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payment_date' => 'required|date',
        ]);
    
        // 1. Crear la nómina principal
        $payroll = Payroll::create([
            'company_id' => $request->company_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'payment_date' => $request->payment_date,
            'status' => 'generada',
        ]);
    
        // 2. Buscar empleados activos en esa empresa (sin removed_at)
        $empleadosActivos = EmployeeCompany::with('employee')
            ->where('company_id', $request->company_id)
            ->whereNull('removed_at')
            ->get()
            ->pluck('employee');
    
        // 3. Procesar cada empleado con cálculo automático
        foreach ($empleadosActivos as $empleado) {
            // Calcular automáticamente valores por ley
            $calculo = PayrollCalculator::calcularParaEmpleado($empleado, 15, $request->start_date, $request->end_date);
    
            // Crear detalle de nómina
            $detail = PayrollDetail::create([
                'payroll_id' => $payroll->id,
                'employee_id' => $empleado->id,
                'base_salary' => $empleado->salary ?? 0,
                'days_worked' => 15,
                'transport_aid' => 0,
                'total_earnings' => $calculo['total_earnings'],
                'total_deductions' => $calculo['total_deductions'],
                'net_salary' => $calculo['net_salary'],
            ]);
    
            // Registrar ítems: devengados y deducciones
            foreach (array_merge($calculo['devengados'], $calculo['deducciones']) as $item) {
                PayrollDetailItem::create([
                    'payroll_detail_id' => $detail->id,
                    'concept_id' => null, // opcional: si conectas con catálogos
                    'type' => $item['type'],
                    'description' => $item['name'],
                    'amount' => $item['amount'],
                ]);
            }
        }
    
        return redirect()
            ->route('payrolls.show', $payroll)
            ->with('success', 'Nómina creada y empleados precargados correctamente con cálculo automático.');
    }

    //consultar nomina
    public function edit($id)
    {
        $payroll = Payroll::with(['payrollDetails', 'company'])->findOrFail($id);
    
        // Opción 1: Usando la relación belongsToMany
        $employees = Employee::where('status', 'active')
        ->whereHas('assignments', function ($query) use ($payroll) {
            $query->where('company_id', $payroll->company_id)
                  ->whereNull('removed_at');
        })
        ->get();

    
        return view('payrolls.edit', compact('payroll', 'employees'));
    }
    //cerrar nómina
    public function close(Payroll $payroll)
    {
        $payroll->update(['status' => 'cerrada']);

        return redirect()->route('payrolls.show', $payroll->id)
            ->with('success', 'Nómina cerrada correctamente. Ya no se pueden realizar modificaciones.');
    }

    //exportar a excel
    public function exportExcel(Payroll $payroll)
    {
        return Excel::download(new PayrollExport($payroll), 'NOMINA_'.$payroll->company->name.'_'.now()->format('d-m-Y').'.xlsx');
    }


}