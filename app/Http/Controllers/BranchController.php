<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Employee;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::paginate(5);
        $employees = Employee::with('member:name,employee_id')->get();
        return view('master.branch.list', compact('branches','employees'));
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
            'branch_code' => 'required|string|max:20|unique:branches,branch_code',
            'name' => 'required|string|max:100',
            'location' => 'required|string',
            // 'manager_id' => 'required|exists:employees,id'
        ]);

        $branch = Branch::create($request->all());
        return redirect()->back()->with('success','Branch Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $branch = Branch::with('manager')->findOrFail($id);
        return response()->json($branch);
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
        $branch = Branch::findOrFail($id);

        $request->validate([
            'branch_code' => 'sometimes|string|max:20|unique:branches,branch_code,' . $id,
            'name' => 'sometimes|string|max:100',
            'location' => 'sometimes|string',
            // 'manager_id' => 'sometimes|exists:employees,id'
        ]);

        $branch->update($request->all());
        return redirect()->back()->with('success','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return redirect()->back()->with('success','Branch record deleted successfully');
    }
}