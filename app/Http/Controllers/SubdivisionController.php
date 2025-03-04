<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subdivision;
use App\Models\Division;
use Illuminate\Validation\Rule;

class SubdivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subdivisions = Subdivision::with('division')->paginate(5);
        $divisions = Division::all();
        // return response()->json($subdivisions);
        return view('master.sub-division.list',compact('subdivisions','divisions'));
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
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string|max:100|unique:subdivisions,name',
            'naav' => 'nullable|string|max:100|unique:subdivisions,naav',
            'address' => 'nullable|string',
            'marathi_address' => 'nullable|string',
            'description' => 'nullable|string',
            'marathi_description' => 'nullable|string',
        ]);
        // return $request->all();
        
        $subdivision = Subdivision::create($validated);
        return redirect()->back()->with('success', 'Subdivision created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subdivision = Subdivision::with('division')->findOrFail($id);
        return response()->json($subdivision);
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
        $subdivision = Subdivision::find($id);
        if (!$subdivision) return response()->json(['message' => 'Not Found'], 404);
        
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'name' => [
            'required','string','max:100',
                Rule::unique('subdivisions', 'name')->ignore($request->id), // Ignore the current record
            ],
            'naav' => [
                'nullable','string','max:100',
                Rule::unique('subdivisions', 'naav')->ignore($request->id), // Ignore the current record
            ],
            'address' => 'nullable|string',
            'marathi_address' => 'nullable|string',
            'description' => 'nullable|string',
            'marathi_description' => 'nullable|string',
        ]);
        
        $subdivision->update($request->all());
        // return response()->json($subdivision, 200);
        return redirect()->back()->with('success', 'Subdivision updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subdivision = Subdivision::findOrFail($id);
        $subdivision->delete();
        return redirect()->back()->with('success', 'Subdivision deleted successfully');
    }
}