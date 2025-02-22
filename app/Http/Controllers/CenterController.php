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
        // $centers = Center::with('subdivision')->get();
        // return response()->json($centers);
        return view('master.center.list');
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
            'subdivision_id' => 'required|exists:subdivisions,id',
            'name' => 'required|string|max:100',
            'naav' => 'required|string|max:100',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $center = Center::create($request->all());
        return response()->json($center, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $center = Center::find($id);
        if (!$center) return response()->json(['message' => 'Not Found'], 404);

        $request->validate([
            'subdivision_id' => 'exists:subdivisions,id',
            'name' => 'string|max:100',
            'naav' => 'string|max:100',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $center->update($request->all());
        return response()->json($center, 200);
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
            'subdivision_id' => 'exists:subdivisions,id',
            'name' => 'string|max:100',
            'naav' => 'string|max:100',
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