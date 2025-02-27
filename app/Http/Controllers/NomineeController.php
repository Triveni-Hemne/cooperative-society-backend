<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nominee;

class NomineeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Nominee::all(), 200);
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
            'member_id' => 'required|exists:members,id',
            'linked_entity_id' => 'required|integer',
            'linked_entity_type' => 'required|in:Member,Deposit_Account',
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|in:Male,Female,Other',
            'relation' => 'required|string|max:50',
            'nominee_image' => 'nullable|string|max:255'
        ]);

        $nominee = Nominee::create($request->all());
        return response()->json($nominee, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nominee = Nominee::find($id);
        if (!$nominee) return response()->json(['message' => 'Nominee not found'], 404);
        return response()->json($nominee, 200);
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
        $nominee = Nominee::find($id);
        if (!$nominee) return response()->json(['message' => 'Nominee not found'], 404);

        $request->validate([
            'name' => 'string|max:255',
            'age' => 'integer',
            'gender' => 'in:Male,Female,Other',
            'relation' => 'string|max:50',
            'nominee_image' => 'nullable|string|max:255'
        ]);

        $nominee->update($request->all());
        return response()->json($nominee, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nominee = Nominee::find($id);
        if (!$nominee) return response()->json(['message' => 'Nominee not found'], 404);

        $nominee->delete();
        return response()->json(['message' => 'Nominee deleted'], 200);
    }
}