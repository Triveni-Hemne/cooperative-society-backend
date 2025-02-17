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
      $employees = Employee::with('designation')->get();
        return response()->json($employees);
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
            'emp_code' => 'required|string|max:50|unique:employees',
            'designation_id' => 'required|exists:designations,id',
            'salary' => 'nullable|numeric|min:0',
            'other_allowance' => 'nullable|numeric|min:0',
            'division_id' => 'required|exists:divisions,id',
            'subdivision_id' => 'nullable|exists:subdivisions,id',
            'center_id' => 'nullable|exists:centers,id',
            'joining_date' => 'required|date',
            'transfer_date' => 'nullable|date',
            'retirement_date' => 'nullable|date',
            'gpf_no' => 'nullable|string|max:50|unique:employees',
            'hra' => 'nullable|numeric|min:0',
            'da' => 'nullable|numeric|min:0',
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
            'emp_code' => "required|string|max:50|unique:employees,emp_code,{$employee->id}",
            'designation_id' => 'required|exists:designations,id',
            'salary' => 'nullable|numeric|min:0',
            'other_allowance' => 'nullable|numeric|min:0',
            'division_id' => 'required|exists:divisions,id',
            'subdivision_id' => 'nullable|exists:subdivisions,id',
            'center_id' => 'nullable|exists:centers,id',
            'joining_date' => 'required|date',
            'transfer_date' => 'nullable|date',
            'retirement_date' => 'nullable|date',
            'gpf_no' => "nullable|string|max:50|unique:employees,gpf_no,{$employee->id}",
            'hra' => 'nullable|numeric|min:0',
            'da' => 'nullable|numeric|min:0',
            'status' => 'required|in:Active,Inactive,Retired',
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