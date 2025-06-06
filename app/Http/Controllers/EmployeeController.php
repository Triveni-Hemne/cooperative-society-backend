<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee; 
use Illuminate\Validation\Rule;
use App\Models\Nominee;
use App\Models\MemberBankDetail;
use App\Models\MemberFinancial;
use App\Models\Branch;
use App\Models\User;
use App\Models\Department;
use App\Models\Division;
use App\Models\Subdivision;
use App\Models\Subcaste;
use App\Models\Director;
use App\Models\Designation;
use App\Models\MemberContactDetail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $branchId = null;
        // Determine branch filter based on role
        if ($user->role === 'Admin') {
            $branchId = $request->branch_id; // admin can filter via dropdown
        } else {
            $branchId = $user->branch_id; // normal user only sees their branch
        }
       $employees = Employee::when($branchId, function ($query) use ($branchId) {
            $query->where(function ($query) use ($branchId) {
                $query->whereHas('user', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })->orWhereHas('branch', function ($q) use ($branchId) {
                    $q->where('id', $branchId);
                });
            });
        })->latest()->paginate(5);

       $departments = Department::all();
       $directors = Director::all();
       $user = Auth::user();
       $divisions = Division::all();
       $subdivisions = Subdivision::all();
       $designations = Designation::all();

       $branches = $user->role === 'Admin' ? Branch::all() : null;
       
       return view('master.employee.list', compact('departments','employees','directors','divisions','subdivisions','designations','user','branches'));
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