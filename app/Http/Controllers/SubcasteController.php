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
       $subcastes = Subcaste::latest()->paginate(5);
        // return response()->json($subcastes);
        return view('master.subcaste.list',compact('subcastes'));
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
            'naav' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'marathi_description' => 'nullable|string',
        ]);
        
        $subcaste = Subcaste::create($validated);
        return redirect()->back()->with('success', 'Subcaste created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       //
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
            'name' => 'required|string|max:100',
            'naav' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'marathi_description' => 'nullable|string',
        ]);

        $subcaste->update($validated);
        return redirect()->back()->with('success', 'Subcaste updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $subcaste = Subcaste::findOrFail($id);
        $subcaste->delete();
        return redirect()->back()->with('success', 'Subcaste deleted successfully');
    }
}