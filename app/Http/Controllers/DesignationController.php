<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $designations = Designation::all();
        // return response()->json($designations);
        return view('master.designation.list');
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
            'name' => 'required|string|max:100',
            'naav' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $designation = Designation::create($validated);
        return response()->json(['message' => 'Designation created successfully', 'designation' => $designation], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $designation = Designation::findOrFail($id);
        return response()->json($designation);
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
       $designation = Designation::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'naav' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $designation->update($validated);
        return response()->json(['message' => 'Designation updated successfully', 'designation' => $designation]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();
        return response()->json(['message' => 'Designation deleted successfully']);
    }
}