<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Director;
use App\Models\Member;
use App\Models\Designation;
use Illuminate\Validation\Rule;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directors = Director::with(['member', 'designation'])->latest()->paginate(5);
        $members = Member::with('contact')->get();
        $designations = Designation::all();
        return view('master.director.list',compact('directors','members','designations'));
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
            'designation_id' => 'nullable|exists:designations,id',
            'contact_nos'=>'required|array|min:1',
            'contact_nos.*' => 'required|numeric',
            'email' => 'nullable|email|unique:directors,email',
            'from_date' => 'required|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);
            $validated['contact_nos'] = implode(',', $request->contact_nos); // Convert array to string
            
            Director::create($validated);

            return redirect()->back()->with('success', 'Director added successfully!');
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
        $director = Director::findOrFail($id);
        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'name' => 'required|string|max:255',
            'designation_id' => 'nullable|exists:designations,id',
            'contact_nos' => 'required|array|min:1', // Ensure at least one number is provided
            'email' => ['nullable', 'email', Rule::unique('directors', 'email')->ignore($director->id)],
            'from_date' => 'required|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);
        
        $validated['contact_nos'] = implode(',', $validated['contact_nos']); 
        
        $director->update($validated);

       return redirect()->back()->with('success', 'Director updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $director = Director::find($id);
        if (!$director) return response()->json(['message' => 'Director not found'], 404);

        $director->delete();
        return redirect()->back()->with('success', 'Director deleted successfully');
    }
}