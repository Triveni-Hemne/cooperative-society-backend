<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcaste;

class SubcasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $subcastes = Subcaste::all();
        return response()->json($subcastes);
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
            'description' => 'nullable|string',
        ]);

        $subcaste = Subcaste::create($validated);
        return response()->json(['message' => 'Subcaste created successfully', 'subcaste' => $subcaste], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subcaste = Subcaste::findOrFail($id);
        return response()->json($subcaste);
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
       $subcaste = Subcaste::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $subcaste->update($validated);
        return response()->json(['message' => 'Subcaste updated successfully', 'subcaste' => $subcaste]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $subcaste = Subcaste::findOrFail($id);
        $subcaste->delete();
        return response()->json(['message' => 'Subcaste deleted successfully']);
    }
}