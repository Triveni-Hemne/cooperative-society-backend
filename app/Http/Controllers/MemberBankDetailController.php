<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberBankDetail;

class MemberBankDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return response()->json(MemberBankDetail::all(), 200);
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
            'member_id' => 'required|exists:members,id',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:11',
            'bank_account_no' => 'required|string|max:50|unique:member_bank_details,bank_account_no',
            'proof_1_no' => 'nullable|string|max:50|unique:member_bank_details,proof_1_no',
            'proof_1_type' => 'nullable|string|max:50',
            'proof_2_no' => 'nullable|string|max:50|unique:member_bank_details,proof_2_no',
            'proof_2_type' => 'nullable|string|max:50',
        ]);

        $bankDetail = MemberBankDetail::create($request->all());

        return response()->json($bankDetail, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bankDetail = MemberBankDetail::find($id);

        if (!$bankDetail) {
            return response()->json(['message' => 'Bank detail not found'], 404);
        }

        return response()->json($bankDetail, 200);
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
        $bankDetail = MemberBankDetail::find($id);

        if (!$bankDetail) {
            return response()->json(['message' => 'Bank detail not found'], 404);
        }

        $request->validate([
            'bank_name' => 'sometimes|string|max:255',
            'branch_name' => 'sometimes|string|max:255',
            'ifsc_code' => 'sometimes|string|max:11',
            'bank_account_no' => 'sometimes|string|max:50|unique:member_bank_details,bank_account_no,' . $id,
            'proof_1_no' => 'nullable|string|max:50|unique:member_bank_details,proof_1_no,' . $id,
            'proof_1_type' => 'nullable|string|max:50',
            'proof_2_no' => 'nullable|string|max:50|unique:member_bank_details,proof_2_no,' . $id,
            'proof_2_type' => 'nullable|string|max:50',
        ]);

        $bankDetail->update($request->all());

        return response()->json(['message' => 'Member bank details updated successfully', 'subcaste' => $bankDetail]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bankDetail = MemberBankDetail::find($id);

        if (!$bankDetail) {
            return response()->json(['message' => 'Bank detail not found'], 404);
        }

        $bankDetail->delete();

        return response()->json(['message' => 'Bank detail deleted successfully'], 200);
    }
}