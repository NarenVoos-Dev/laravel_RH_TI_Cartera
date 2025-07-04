<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
  
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        $companies = Company::all();
        return view('users.index', compact('users','roles','companies'));
    }

 
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'company_id' => 'nullable|exists:companies,id',
            'status' => 'required|in:active,inactive',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id; // opcional
        $user->company_id = $request->company_id; // opcional
        $user->status = $request->status;
        $user->save();

        // Asignar rol con Spatie
        $rolNombre = Role::find($request->role_id)->name;
        $user->assignRole($rolNombre);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'user' => $user
        ], 201);
    }

 
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        if(!$user){
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        return response()->json($user); // Retorna los datos del usuario
    }

 
    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role_id' => 'required|exists:roles,id',
            'company_id' => 'nullable|exists:companies,id',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->role_id = $request->input('role_id');
            $user->company_id = $request->input('company_id');
            $user->status = $request->input('status');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();

            // Actualizar rol con Spatie
            $rolNombre = Role::find($request->role_id)->name;
            $user->syncRoles([$rolNombre]);

            return response()->json([
                'message' => 'Usuario actualizado exitosamente',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el usuario: ' . $e->getMessage(),
            ], 500);
        }
    }

    

    public function destroy(string $id)
    {
        //
    }

       //fncion para desactivar empleado y no eliminar
    public function inactivate(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'No se encontro el empleado'], 404);
        }
        $user->update([
            'status' => 'inactive'
        ]);
        return response()->json(['message' => 'Empleado inactivado correctamente'], 200);
    }
}