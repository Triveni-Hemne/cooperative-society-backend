<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee; 
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return response()->json(Employee::with(['member', 'designation', 'division', 'subdivision', 'center'])->get(), 200);
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
            'emp_code' => 'required|string|max:50|unique:employees,emp_code',
            'designation_id' => 'required|exists:designations,id',
            'salary' => 'required|numeric',
            'other_allowance' => 'nullable|numeric',
            'division_id' => 'required|exists:divisions,id',
            'subdivision_id' => 'required|exists:subdivisions,id',
            'center_id' => 'required|exists:centers,id',
            'joining_date' => 'required|date',
            'transfer_date' => 'nullable|date',
            'retirement_date' => 'nullable|date',
            'gpf_no' => 'nullable|string|max:50|unique:employees,gpf_no',
            'hra' => 'nullable|numeric',
            'da' => 'nullable|numeric',
            'status' => 'required|in:Active,Inactive,Retired',
        ]);

        $employee = Employee::create($validated);
        return response()->json(['message' => 'Employee added successfully', 'employee' => $employee], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with('designation')->findOrFail($id);
        return response()->json($employee);
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
        $employee = Employee::findOrFail($id);

        $validated =  $request->validate([
            'member_id' => 'exists:members,id',
            'emp_code' => 'string|max:50|unique:employees,emp_code,' . $id,
            'designation_id' => 'exists:designations,id',
            'salary' => 'numeric',
            'other_allowance' => 'nullable|numeric',
            'division_id' => 'exists:divisions,id',
            'subdivision_id' => 'exists:subdivisions,id',
            'center_id' => 'exists:centers,id',
            'joining_date' => 'date',
            'transfer_date' => 'nullable|date',
            'retirement_date' => 'nullable|date',
            'gpf_no' => 'nullable|string|max:50|unique:employees,gpf_no,' . $id,
            'hra' => 'nullable|numeric',
            'da' => 'nullable|numeric',
            'status' => 'in:Active,Inactive,Retired',
        ]);

        $employee->update($validated);
        return response()->json(['message' => 'Employee updated successfully', 'employee' => $employee]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}