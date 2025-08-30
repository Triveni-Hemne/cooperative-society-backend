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
        $branches = Branch::latest()->paginate(5);
        $employees = Employee::all();
        $nextBranchNo = $this->getLastBranchNo();
        return view('master.branch.list', compact('branches','employees','nextBranchNo'));
    }


    public function getLastBranchNo()
    {
            $last = Branch::max('branch_code');
            $prefix = "BN";
        // If no record exists yet, start with 1
        if (!$last) {
            $nextNo = $prefix . "01";
        } else {
            // Extract number part (remove prefix, handle cases like R20240510 too)
            preg_match('/(\d+)$/', $last, $matches);
            $number = isset($matches[1]) ? (int)$matches[1] : 0;
            $nextNo = $prefix . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
        }

        return $nextNo;
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
        return redirect()->back()->with('success','Branch Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $branch = Branch::findOrFail($id);
        // $branch->delete();
        return redirect()->back()->with('error','Branch record cant be deleted');
    }
}