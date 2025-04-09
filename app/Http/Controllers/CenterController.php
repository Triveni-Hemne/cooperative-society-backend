<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subdivision;
use App\Models\Division;
use App\Models\Center;
use Illuminate\Validation\Rule;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centers = Center::with('subdivision')->paginate(5);
        $subdivisions = Subdivision::with('division')->get();
        $divisions = Division::all();
        // return response()->json($centers);
        return view('master.center.list', compact('centers', 'subdivisions', 'divisions'));
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
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'subdivision_id' => 'required|exists:subdivisions,id',
            'name' => 'required|string|max:100|unique:centers,name',
            'naav' => 'nullable|string|max:100|unique:centers,naav',
            'address' => 'nullable|string',
            'marathi_address' => 'nullable|string',
            'description' => 'nullable|string',
            'marathi_description' => 'nullable|string',
        ]);
        $center = Center::create($request->all());
        // return response()->json($center, 201);
        return redirect()->back()->with('success', 'Center created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
        $center = Center::findOrFail($id);
        
        $validated = $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'subdivision_id' => 'required|exists:subdivisions,id',
            'name' => [
            'required','string','max:100',
                Rule::unique('centers', 'name')->ignore($request->id), // Ignore the current record
            ],
            'naav' => [
               'nullable','string','max:100',
                Rule::unique('centers', 'naav')->ignore($request->id), // Ignore the current record
            ],
            'address' => 'nullable|string',
            'marathi_address' => 'nullable|string',
            'description' => 'nullable|string',
            'marathi_description' => 'nullable|string',
        ]);
        
        // return $request->all();
        $center->update($validated);
        return redirect()->back()->with('success', 'Center updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $center = Center::findOrFail($id);
        $center->delete();
        return redirect()->back()->with('success', 'Center deleted successfully');
    }
}