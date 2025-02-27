<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $divisions = Division::all();
        // return response()->json($divisions);
        return view('master.division.list');
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
            'name' => 'required|string|max:255',
            'naav' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $division = Division::create($validated);
        return response()->json(['message' => 'Division created successfully', 'division' => $division], 201);
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
            'name' => 'required|string|max:255',
            'naav' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $division->update($validated);
        return response()->json(['message' => 'Division updated successfully', 'division' => $division]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $division = Division::findOrFail($id);
        $division->delete();
        return response()->json(['message' => 'Division deleted successfully']);
    }
}