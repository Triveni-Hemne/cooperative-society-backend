<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\Subdivision;
use App\Models\Center;
use App\Models\Division;
use Illuminate\Validation\Rule;
class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $designations = Designation::with('subdivision')->paginate(5);
        $subdivisions = Subdivision::all();
        $divisions = Division::all();
        $centers = Center::all();
        return view('master.designation.list',compact('designations','subdivisions','divisions','centers'));
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
            'subdivision_id' => 'required|exists:subdivisions,id',
            'center_id' => 'nullable|exists:centers,id',
            'name' => 'required|string|max:100|unique:designations,name',
            'naav' => 'nullable|string|max:100|unique:designations,naav',
            'description' => 'nullable|string',
        ]);
        
        $designation = Designation::create($validated);
        return redirect()->back()->with('success', 'Designation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $designation = Designation::findOrFail($id);
        return response()->json($designation);
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
       $designation = Designation::findOrFail($id);

       $validated = $request->validate([
           'division_id' => 'required|exists:divisions,id',
           'subdivision_id' => 'required|exists:subdivisions,id',
           'center_id' => 'nullable|exists:centers,id',
           'name' => [
            'required','string','max:100',
                Rule::unique('designations', 'name')->ignore($request->id), // Ignore the current record
            ],
            'naav' => [
                'nullable','string','max:100',
                Rule::unique('designations', 'naav')->ignore($request->id), // Ignore the current record
            ],
           'description' => 'nullable|string',
        ]);

        $designation->update($validated);
        return  redirect()->back()->with('success', 'Designation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();
        return redirect()->back()->with('success', 'Designation deleted successfully');
    }
}