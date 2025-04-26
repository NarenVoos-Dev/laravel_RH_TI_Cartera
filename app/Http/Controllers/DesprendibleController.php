<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayrollDetail;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class DesprendibleController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();

        // Si es empleado, solo sus colillas
        if ($user->isEmployee() && $user->employee) {
            $payrollDetails = PayrollDetail::where(
                'employee_id', $user->employee->id)
                ->with('payroll.company', 'employee')
                ->latest()
                ->get();
        } else {
            // Si es admin u otro rol, ver todos
            $payrollDetails = PayrollDetail::with(['payroll', 'employee'])
                ->latest()->get();
        }

        return view('payrolls.desprendibles.index', compact('payrollDetails', 'user'));
    }

    public function exportPdf(PayrollDetail $detail)
    {
        $user = auth()->user();
    
        // Si es empleado, solo puede ver su propia colilla
        if ($user->role === 'empleado' && $detail->employee->user_id !== $user->id) {
            abort(403, 'No tienes permiso para ver este desprendible.');
        }
    
        $pdf = Pdf::loadView('reportes.nomina.desprendibles.pdf', compact('detail', 'user'));
        return $pdf->stream('colilla_' . $detail->employee->name . '.pdf');
    }
}
