<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Center;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centers = Center::with('subdivision')->get();
        return response()->json($centers);
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
            'subdivision_id' => 'required|exists:subdivisions,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $center = Center::create($validated);
        return response()->json(['message' => 'Center created successfully', 'center' => $center], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $center = Center::with('subdivision')->findOrFail($id);
        return response()->json($center);
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
            'subdivision_id' => 'required|exists:subdivisions,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $center->update($validated);
        return response()->json(['message' => 'Center updated successfully', 'center' => $center]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $center = Center::findOrFail($id);
        $center->delete();
        return response()->json(['message' => 'Center deleted successfully']);
    }
}