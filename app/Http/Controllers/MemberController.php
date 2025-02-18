<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $members = Member::with(['employee', 'department'])->get();
        return response()->json($members);
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
            'member_id' => 'required|string|max:50|unique:members,member_id',
            'emp_ac_id' => 'nullable|exists:employees,id',
            'department_id' => 'nullable|exists:departments,id',
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'age' => 'required|integer|min:1',
            'date_of_joining' => 'nullable|date',
            'religion' => 'nullable|string|max:100',
            'category' => ['required', Rule::in(['ST', 'OBC', 'General', 'NT'])],
            'caste' => 'required|string|max:100',
            'm_reg_no' => 'nullable|string|max:50',
            'pan_no' => 'nullable|string|max:20',
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $member = Member::create($validated);
        return response()->json(['message' => 'Member added successfully', 'member' => $member], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::with(['employee', 'department'])->findOrFail($id);
        return response()->json($member);
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
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|string|max:50|unique:members,member_id,' . $id,
            'emp_ac_id' => 'nullable|exists:employees,id',
            'department_id' => 'nullable|exists:departments,id',
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'age' => 'required|integer|min:1',
            'date_of_joining' => 'nullable|date',
            'religion' => 'nullable|string|max:100',
            'category' => ['required', Rule::in(['ST', 'OBC', 'General', 'NT'])],
            'caste' => 'required|string|max:100',
            'm_reg_no' => 'nullable|string|max:50',
            'pan_no' => 'nullable|string|max:20',
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $member->update($validated);
        return response()->json(['message' => 'Member updated successfully', 'member' => $member]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $member = Member::findOrFail($id);
        $member->delete();
        return response()->json(['message' => 'Member deleted successfully']);
    }
}