<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Employee;
use App\Models\Company;
use App\Models\EmployeeCompany;
use App\Models\CompanyWallet;

use App\Models\WalletMovement;

class WalletController extends Controller
{
    // Mostrar listado de carteras
    public function index()
    {
        $carteras = Wallet::visible()->get(); // 🔥 Aquí usamos el scope
        $employees = Employee::all();
        $companies = Company::all();
    
        return view('cartera.index', compact('carteras', 'employees', 'companies'));
    }
       

    // Crear cartera
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'issue_date' => 'required|date',
            'concept' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
        ]);
    
        try {
            $employee = Employee::findOrFail($request->employee_id);
    
            // Buscar la empresa asignada desde la tabla intermedia
            $company_id = $employee->currentCompany?->company_id;
    
            if (!$company_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'El empleado no tiene una empresa asignada.'
                ], 422);
            }
    
            $wallet = Wallet::create([
                'employee_id' => $employee->id,
                'company_id' => $company_id, //referencia historica
                'issue_date' => $request->issue_date,
                'concept' => $request->concept,
                'total_amount' => $request->total_amount,
                'balance' => $request->balance ?? $request->total_amount,
            ]);

            $company_id_user = auth()->user()->company_id;

            // Asociar la empresa que originó la cartera (tabla pivote)
            if (!$wallet->companies()->where('company_id', $company_id_user)->exists()) {
                $wallet->companies()->attach($company_id_user);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Cartera creada correctamente',
                'wallet' => $wallet
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la cartera',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    //crear abono
    public function createMovement(Request $request , string $id)   
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:descontar,pagado,cancelado',
        ]);

        try {
            $wallet = Wallet::findOrFail($request->wallet_id);
    
            // Registrar movimiento
            $movement = WalletMovement::create([
                'wallet_id' => $wallet->id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'description' => $request->description ?? '',
                'status' => $request->status,
            ]);
    
            // Actualizar el balance de la cartera
            if($wallet->balance - $request->amount < 0) {
                $wallet->balance = 0;
                return response()->json([
                    'success' => false,
                    'message' => 'El abono excede el saldo de la cartera.',
                    'error' => e->getMessage('El abono excede el saldo de la cartera.')
                ], 422);
            } else {
                $wallet->balance -= $request->amount;
                $wallet->save();

            }
    
            return response()->json([
                'success' => true,
                'message' => 'Abono registrado correctamente.',
                'movement' => $movement,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el abono.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    //Historial de abonos
    public function getMovements($id)
    {
        $wallet = Wallet::with(['employee', 'movements'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'movements' => $wallet->movements,
            'employee' => $wallet->employee->name,
            'balance' => $wallet->balance,
            'total_amount' => $wallet->total_amount,
        ]);
    }
}
