<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeCompany;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Support\Facades\DB;


class EmployeeCompanyController extends Controller
{
    
    public function index()
    {
        $assignments = EmployeeCompany::with(['employee', 'company'])->get();
        // Cargar empresas activas
        $companies = Company::where('status', 'active')->get();

        // Cargar empleados activos
        $employees = Employee::whereDoesntHave('currentAssignment')->get();

        return view('assignments.index', compact('assignments','companies','employees'));
    }

 
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'company_id' => 'required|exists:companies,id',
        ]);

        // Validar que el empleado NO tenga una asignación activa
        $existingAssignment = EmployeeCompany::where('employee_id', $request->employee_id)
        ->whereNull('removed_at')
        ->first();
        if ($existingAssignment) {
            return redirect()->back()->with('error', 'Este empleado ya tiene una asignación activa.');
        }

            // Crear nueva asignación
        EmployeeCompany::create([
            'employee_id' => $request->employee_id,
            'company_id' => $request->company_id,
            'assigned_at' => now(),
        ]);
        return redirect()->route('assignments.index')->with('success', 'Asignación creada correctamente.');

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


    public function destroy(string $id)
    {
        //
    }

    public function changeCompany(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'company_id' => 'required|exists:companies,id',
        ]);

        DB::beginTransaction();
        try {
            // Verificar si ya está asignado a esa empresa
            $alreadyAssigned = EmployeeCompany::where('employee_id', $request->employee_id)
                ->where('company_id', $request->company_id)
                ->whereNull('removed_at')
                ->exists();

            if ($alreadyAssigned) {
                return response()->json([
                    'success' => false,
                    'message' => 'El empleado ya está asignado a esta empresa.',
                ], 422);
            }

            // Desactivar la asignación actual
            EmployeeCompany::where('employee_id', $request->employee_id)
                ->whereNull('removed_at')
                ->update(['removed_at' => now()]);

            // Crear nueva asignación
            EmployeeCompany::create([
                'employee_id' => $request->employee_id,
                'company_id' => $request->company_id,
                'assigned_at' => now(),
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Empresa del empleado actualizada correctamente.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar la empresa.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deactivate($id)
    {
        try {
            $assignment = EmployeeCompany::findOrFail($id);

            if ($assignment->removed_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'La asignación ya está desactivada.'
                ], 400);
            }

            $assignment->removed_at = now();
            $assignment->save();

            return response()->json([
                'success' => true,
                'message' => 'Asignación desactivada correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al desactivar la asignación.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
