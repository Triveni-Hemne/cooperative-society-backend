<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use Illuminate\Validation\Rule;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $divisions = Division::latest()->paginate(5);
        // return response()->json($divisions);
        return view('master.division.list',compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:divisions,name',
            'naav' => 'nullable|string|max:100|unique:divisions,naav',
            'description' => 'nullable|string',
            'marathi_description' => 'nullable|string',
        ]);
        
        // return $request->all();
        $division = Division::create($validated);
        return redirect()->back()->with('success', 'Division created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $division = Division::findOrFail($id);
        return response()->json($division);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $division = Division::findOrFail($id);
        $validated = $request->validate([
           'name' => [
            'required','string','max:100',
                Rule::unique('divisions', 'name')->ignore($request->id), // Ignore the current record
            ],
            'naav' => [
                'nullable','string','max:100',
                Rule::unique('divisions', 'naav')->ignore($request->id), // Ignore the current record
            ],
            'description' => 'nullable|string',
            'marathi_description' => 'nullable|string',
        ]);
        
        $division->update($validated);
        // return response()->json(['message' => 'Division updated successfully', 'division' => $division]);
        return redirect()->back()->with('success','Division updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $division = Division::findOrFail($id);
        $division->delete();
        return redirect()->back()->with('success', 'Division deleted successfully');
        return $division;
    }
}