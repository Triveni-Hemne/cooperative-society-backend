<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberContactDetail;

class MemberContactDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = MemberContactDetail::with('member')->get();
        return response()->json($contacts);
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
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'mobile_no' => 'required|string|max:15',
            'phone_no' => 'nullable|string|max:15',
        ]);

        $contact = MemberContactDetail::create($validated);
        return response()->json(['message' => 'Contact details added successfully', 'contact' => $contact], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = MemberContactDetail::with('member')->findOrFail($id);
        return response()->json($contact);
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
        $contact = MemberContactDetail::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'mobile_no' => 'required|string|max:15',
            'phone_no' => 'nullable|string|max:15',
        ]);

        $contact->update($validated);
        return response()->json(['message' => 'Contact details updated successfully', 'contact' => $contact]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = MemberContactDetail::findOrFail($id);
        $contact->delete();
        return response()->json(['message' => 'Contact details deleted successfully']);
    }
}