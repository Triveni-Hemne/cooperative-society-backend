<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::latest()->paginate(5);
        $employees = Employee::all();
        return view('master.department.list', compact('departments','employees'));
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
            'head_id' => 'nullable|exists:employees,id',
        ]);

        $department = Department::create($validated);
        return redirect()->back()->with('success', 'Department added successfully');
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
            'head_id' => 'nullable|exists:employees,id',
        ]);

        $department->update($validated);
        return redirect()->back()->with('success', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
         return redirect()->back()->with('success', 'Department deleted successfully');
    }
}