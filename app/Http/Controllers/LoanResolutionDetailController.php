<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanResolutionDetail;

class LoanResolutionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return response()->json(LoanResolutionDetail::all(), 200);
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
            'loan_id' => 'required|exists:member_loan_accounts,id',
            'resolution_no' => 'required|string|max:50|unique:loan_resolution_details,resolution_no',
            'resolution_date' => 'required|date',
        ]);

        $loanResolutionDetail = LoanResolutionDetail::create($request->all());
        return response()->json($loanResolutionDetail, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $loanResolutionDetail = LoanResolutionDetail::find($id);
        if (!$loanResolutionDetail) return response()->json(['message' => 'Not Found'], 404);
        return response()->json($loanResolutionDetail, 200);
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
        $loanResolutionDetail = LoanResolutionDetail::find($id);
        if (!$loanResolutionDetail) return response()->json(['message' => 'Not Found'], 404);

        $request->validate([
            'resolution_no' => 'string|max:50|unique:loan_resolution_details,resolution_no,' . $id,
            'resolution_date' => 'date',
        ]);

        $loanResolutionDetail->update($request->all());
        return response()->json($loanResolutionDetail, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loanResolutionDetail = LoanResolutionDetail::find($id);
        if (!$loanResolutionDetail) return response()->json(['message' => 'Not Found'], 404);

        $loanResolutionDetail->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}