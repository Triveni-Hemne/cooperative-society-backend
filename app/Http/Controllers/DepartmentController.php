<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::with('head')->get();
        return response()->json($departments);
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
            'name' => 'required|string|max:100|unique:departments,name',
            'head_id' => 'required|exists:employees,id',
        ]);

        $department = Department::create($validated);
        return response()->json(['message' => 'Department added successfully', 'department' => $department], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $department = Department::with('head')->findOrFail($id);
        return response()->json($department);
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
       $department = Department::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('departments')->ignore($department->id)],
            'head_id' => 'required|exists:employees,id',
        ]);

        $department->update($validated);
        return response()->json(['message' => 'Department updated successfully', 'department' => $department]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return response()->json(['message' => 'Department deleted successfully']);
    }
}