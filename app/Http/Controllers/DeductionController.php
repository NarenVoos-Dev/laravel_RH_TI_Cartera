<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deduction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DeductionController extends Controller
{
    public function index()
    {
        $deductions = Deduction::all();
        return view('deductions.index', compact('deductions'));
    }

    public function create()
    {
        return view('deductions.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'nullable|numeric',
        ]);

       

        Deduction::create([
            'name' => $request->name,
            'percentage' => $request->percentage,
            'is_mandatory' => $request->has('is_mandatory'),
            'is_editable' => $request->has('is_editable'),
        ]);
 

        return redirect()->route('deductions.index')->with('success', 'Deducción creada correctamente.');
    }

    public function edit(Deduction $deduction)
    {
        return view('deductions.edit', compact('deduction'));
    }

    public function update(Request $request, Deduction $deduction)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'nullable|numeric',

        ]);

        $deduction->update([
            'name' => $request->name,
            'percentage' => $request->percentage,
            'is_mandatory' => $request->has('is_mandatory'),
            'is_editable' => $request->has('is_editable'),
        ]);

        return redirect()->route('deductions.index')->with('success', 'Deducción actualizada correctamente.');
    }

    public function destroy(Deduction $deduction)
    {
        $deduction->delete();
        return redirect()->route('deductions.index')->with('success', 'Deducción eliminada correctamente.');
    }
}