<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberNominee;
use Illuminate\Validation\Rule;

class MemberNomineeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nominees = MemberNominee::with('member')->get();
        return response()->json($nominees);
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
            'member_id' => 'required|exists:members,id',
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'relation' => 'required|string|max:50',
            'image' => 'nullable|string|max:255',
        ]);

        $nominee = MemberNominee::create($validated);
        return response()->json(['message' => 'Nominee added successfully', 'nominee' => $nominee], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nominee = MemberNominee::with('member')->findOrFail($id);
        return response()->json($nominee);
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
       $nominee = MemberNominee::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'relation' => 'required|string|max:50',
            'image' => 'nullable|string|max:255',
        ]);

        $nominee->update($validated);
        return response()->json(['message' => 'Nominee updated successfully', 'nominee' => $nominee]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nominee = MemberNominee::findOrFail($id);
        $nominee->delete();
        return response()->json(['message' => 'Nominee deleted successfully']);
    }
}