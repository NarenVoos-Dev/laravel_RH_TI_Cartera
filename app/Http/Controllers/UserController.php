<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('users.index', compact('users','roles'));
    }

 
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8', // Confirmación de contraseña
            'role_id' => 'required|exists:roles,id', // Asegura que el rol existe
            'status' => 'required|in:active,inactive',
        ]);
    
        // Crear el nuevo usuario
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password); // Encriptar la contraseña
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        $user->save();
    
        // Retornar una respuesta en formato JSON
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
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8', // La contraseña es opcional pero si se pasa debe confirmarse
        ]);

        try {
            // Buscar el usuario por su ID
            $user = User::findOrFail($id);

            // Actualizar los campos del usuario
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->role_id = $request->input('role_id');
            $user->status = $request->input('status');

            // Si la contraseña es proporcionada, la encriptamos y la asignamos
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            // Guardar el usuario actualizado
            $user->save();

            // Responder con éxito
            return response()->json([
                'message' => 'Usuario actualizado exitosamente',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            // Si ocurre algún error, devolver un error
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