<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Earning;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EarningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $earnings = Earning::all();
        return view('earnings.index', compact('earnings'));
    }


    public function create()
    {
        return view('earnings.create');
    }

    // Guardar nuevo devengado
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'default_value' => 'nullable|numeric',
            'is_editable' => 'nullable|boolean',
            'is_taxable' => 'nullable|boolean',
        ]);

        Earning::create([
            'name' => $request->name,
            'default_value' => $request->default_value,
            'is_editable' => $request->has('is_editable'),
            'is_taxable' => $request->has('is_taxable'),
        ]);

        return redirect()->route('earnings.index')->with('success', 'Devengado creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // Mostrar formulario de edición
    public function edit(Earning $earning)
    {
        return view('earnings.edit', compact('earning'));
    }


     // Actualizar devengado
     public function update(Request $request, Earning $earning)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'default_value' => 'nullable|numeric',
             'is_editable' => 'nullable|boolean',
             'is_taxable' => 'nullable|boolean',
         ]);
 
         $earning->update([
             'name' => $request->name,
             'default_value' => $request->default_value,
             'is_editable' => $request->has('is_editable'),
             'is_taxable' => $request->has('is_taxable'),
         ]);
 
         return redirect()->route('earnings.index')->with('success', 'Devengado actualizado correctamente.');
     }
    // Eliminar devengado
    public function destroy(Earning $earning)
    {
        $earning->delete();
        return redirect()->route('earnings.index')->with('success', 'Devengado eliminado correctamente.');
    }
}
