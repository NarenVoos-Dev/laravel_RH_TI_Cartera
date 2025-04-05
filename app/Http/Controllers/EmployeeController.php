<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Role;

class EmployeeController extends Controller
{
    
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        //
    }

 //crear empleado con usuario y rol por defecto
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'document_identification' => 'required|unique:employees,document_identification',
            'salary' => 'required|numeric',
            'transport_aid' => 'nullable|numeric',
            'hire_date' => 'required|date',
            'status' => 'required',
        ]);

        // 1. Crear el usuario y asignarlo al empleado
        $user = User::create([
            'name' => $request->name,
            'username' => $request->document_identification,
            'password' => bcrypt('123456'), // Puedes generar una contraseña aleatoria
        ]);

        // 2. Crear el empleado con  user_id
        Employee::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'document_identification' => $request->document_identification,
            'salary' => $request->salary,
            'transport_aid' => $request->transport_aid,
            'hire_date' => $request->hire_date,
            'status' => $request->status,
        ]);


        return response()->json(['message' => 'Empleado creado correctamente'], 201);

    }
  
    public function show(string $id)
    {
        $employee = Employee::find($id);
    
        if (!$employee) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
    
        return response()->json($employee); // Retorna los datos del empleado
    }

 //llevar información del empleado 
    public function edit(string $id)
    {
      //
    }

    public function update(Request $request, string $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'document_identification' => 'required|unique:employees,document_identification,' . $id, // Aseguramos que el documento de identificación sea único, pero permitimos el valor actual
            'salary' => 'required|numeric',
            'transport_aid' => 'nullable|numeric',
            'hire_date' => 'required|date',
            'status' => 'required',
        ]);
    
        // 2. Buscar el empleado por ID y actualizar
        $employee = Employee::find($id);
    
        if (!$employee) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
    
        // Actualizar los datos del empleado
        $employee->update([
            'name' => $request->name,
            'document_identification' => $request->document_identification,
            'salary' => $request->salary,
            'transport_aid' => $request->transport_aid,
            'hire_date' => $request->hire_date,
            'status' => $request->status,
        ]);
    
        // Retornar respuesta exitosa
        return response()->json(['message' => 'Empleado actualizado correctamente'], 200);
    }
    
    public function destroy(string $id)
    {
        //
    }

    //fncion para desactivar empleado y no eliminar
    public function inactivate(string $id)
    {
        $employee = Employee::find($id);
        if(!$employee){
            return response()->json(['message' => 'No se encontro el empleado'], 404);
        }
        $employee->update([
            'status' => 'inactive'
        ]);
        return response()->json(['message' => 'Empleado inactivado correctamente'], 200);
    }
}
