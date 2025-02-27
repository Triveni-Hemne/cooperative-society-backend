<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subdivision;

class SubdivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subdivisions = Subdivision::with('division')->get();
        // return response()->json($subdivisions);
        return view('master.sub-division.list');
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
            'name' => 'required|string|max:100',
            'naav' => 'required|string|max:100',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $subdivision = Subdivision::create($validated);
        return response()->json(['message' => 'Subdivision created successfully', 'subdivision' => $subdivision], 201);
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
            'division_id' => 'exists:divisions,id',
            'name' => 'string|max:100',
            'naav' => 'string|max:100',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $subdivision->update($request->all());
        return response()->json($subdivision, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subdivision = Subdivision::findOrFail($id);
        $subdivision->delete();
        return response()->json(['message' => 'Subdivision deleted successfully']);
    }
}