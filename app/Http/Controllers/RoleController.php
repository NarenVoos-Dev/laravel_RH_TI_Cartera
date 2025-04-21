<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
   
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('roles.index', compact('roles', 'permissions'));
    }


    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    
        return response()->json(['message' => 'Rol creado exitosamente'], 201);
    }

    /**
     * Display the specified resource.
     */
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
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
    
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(['success' => true]);
    }

    public function editPermissions(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.permisosRole', compact('role', 'permissions'));
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);
    
        $role->syncPermissions($request->permissions ?? []);
    
        return redirect()->route('roles.index')->with('success', 'Permisos actualizados correctamente.');
    }
    
}
