<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
   
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nit' => 'required|string|max:50|unique:companies,nit',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'type' => 'required|in:externa,interna',
            'status' => 'required|in:active,inactive',
        ]);
    
        try {
            $company = Company::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Empresa creada correctamente',
                'company' => $company
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la empresa: ' . $e->getMessage()
            ], 500);
        }
    }
    


 
    public function show(string $id)
    {
        $company = Company::find($id);
    
        if (!$company) {
            return response()->json(['error' => 'Empresa no encontrada'], 404);
        }
    
        return response()->json($company); // Retorna los datos de la empresa
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nit' => 'required|string|max:50|unique:companies,nit,' . $id,            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'type' => 'required|in:externa,interna',
            'status' => 'required',
        ]);

        // 1. Buscar la empresa por ID
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['error' => 'Empresa no encontrada'], 404);
        }

        // 2. Actualizar los datos de la empresa
        $company->update([
            'name' => $request->name,
            'nit' => $request->nit,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status,
            'type' => $request->type,
        ]);

        // 3. Retornar respuesta exitosa
        return response()->json(['message' => 'Empresa actualizada correctamente'], 200);
    }

 
    public function destroy(string $id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['error' => 'Empresa no encontrada'], 404);
        }

        // 2. Eliminar la empresa
        $company->delete();

        // 3. Retornar respuesta exitosa
        return response()->json(['message' => 'Empresa eliminada correctamente'], 200);
    }

}
