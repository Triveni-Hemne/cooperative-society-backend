<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Director;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Director::with(['member', 'designation'])->get(), 200);
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
            'member_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'naav' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:directors,email',
            'contact_no' => 'required|string|max:20',
            'designation_id' => 'required|exists:designations,id',
            'status' => 'required|in:Active,Inactive',
            'from_date' => 'required|date',
            'to_date' => 'nullable|date'
        ]);

        $director = Director::create($request->all());
        return response()->json($director, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $director = Director::with(['member', 'designation'])->find($id);
        if (!$director) return response()->json(['message' => 'Director not found'], 404);
        return response()->json($director, 200);
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
        $director = Director::find($id);
        if (!$director) return response()->json(['message' => 'Director not found'], 404);

        $request->validate([
            'email' => 'string|email|max:255|unique:directors,email,' . $id,
            'contact_no' => 'string|max:20',
            'status' => 'in:Active,Inactive',
            'from_date' => 'date',
            'to_date' => 'nullable|date'
        ]);

        $director->update($request->all());
        return response()->json($director, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $director = Director::find($id);
        if (!$director) return response()->json(['message' => 'Director not found'], 404);

        $director->delete();
        return response()->json(['message' => 'Director deleted'], 200);
    }
}