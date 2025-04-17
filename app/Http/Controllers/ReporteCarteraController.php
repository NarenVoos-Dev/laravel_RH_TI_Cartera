<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Employee;
use App\Models\Company;

//exportar a excel
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MovimientosExport;


//pdf
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\WalletMovement;

class ReporteCarteraController extends Controller
{
    public function index(Request $request)
    {
        $query = WalletMovement::with(['wallet.employee', 'wallet.company']);

        if ($request->filled('employee_id')) {
            $query->whereHas('wallet', function ($q) use ($request) {
                $q->where('employee_id', $request->employee_id);
            });
        }

        if ($request->filled('company_id')) {
            $query->whereHas('wallet', function ($q) use ($request) {
                $q->where('company_id', $request->company_id);
            });
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);
        }

        $movimientos = $query->latest()->get();
        $empleados = \App\Models\Employee::orderBy('name')->get();
        $companias = \App\Models\Company::orderBy('name')->get();

        return view('reportes.carteras.index', compact('movimientos', 'empleados', 'companias'));
    }

    public function exportExcel(Request $request)
    {
        $query = WalletMovement::with(['wallet.employee', 'wallet.company']);

        if ($request->filled('employee_id')) {
            $query->whereHas('wallet', function ($q) use ($request) {
                $q->where('employee_id', $request->employee_id);
            });
        }

        if ($request->filled('company_id')) {
            $query->whereHas('wallet', function ($q) use ($request) {
                $q->where('company_id', $request->company_id);
            });
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);
        }

        $movimientos = $query->latest()->get();

        return Excel::download(new MovimientosExport($movimientos), 'reporte_movimientos.xlsx');
    }

    public function exportarPDF(Request $request)
    {
        $query = WalletMovement::with(['wallet.employee', 'wallet.company']);

        if ($request->filled('employee_id')) {
            $query->whereHas('wallet', function ($q) use ($request) {
                $q->where('employee_id', $request->employee_id);
            });
        }

        if ($request->filled('company_id')) {
            $query->whereHas('wallet', function ($q) use ($request) {
                $q->where('company_id', $request->company_id);
            });
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);
        }

        $movimientos = $query->latest()->get();

        $html = view('reportes.carteras.pdf', compact('movimientos'))->render();
        $pdf = Pdf::loadView('reportes.carteras.pdf', compact('movimientos'))->setPaper('a4', 'portrait');
        return $pdf->download('reporte_movimientos.pdf');
    }
    

}
