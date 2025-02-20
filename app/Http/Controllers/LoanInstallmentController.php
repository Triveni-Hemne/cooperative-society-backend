<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanInstallment;

class LoanInstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return response()->json(LoanInstallment::all(), 200);
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
            'installment_type' => 'required|in:Monthly,Quarterly,Yearly',
            'mature_date' => 'nullable|date',
            'first_installment_date' => 'nullable|date',
            'total_installments' => 'required|integer|min:1',
            'installment_amount' => 'required|numeric|min:0',
            'installment_with_interest' => 'required|numeric|min:0',
            'total_installments_paid' => 'integer|min:0',
        ]);

        $loanInstallment = LoanInstallment::create($request->all());
        return response()->json($loanInstallment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $loanInstallment = LoanInstallment::find($id);
        if (!$loanInstallment) return response()->json(['message' => 'Not Found'], 404);
        return response()->json($loanInstallment, 200);
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
        $loanInstallment = LoanInstallment::find($id);
        if (!$loanInstallment) return response()->json(['message' => 'Not Found'], 404);

        $request->validate([
            'installment_type' => 'in:Monthly,Quarterly,Yearly',
            'mature_date' => 'nullable|date',
            'first_installment_date' => 'nullable|date',
            'total_installments' => 'integer|min:1',
            'installment_amount' => 'numeric|min:0',
            'installment_with_interest' => 'numeric|min:0',
            'total_installments_paid' => 'integer|min:0',
        ]);

        $loanInstallment->update($request->all());
        return response()->json($loanInstallment, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $loanInstallment = LoanInstallment::find($id);
        if (!$loanInstallment) return response()->json(['message' => 'Not Found'], 404);

        $loanInstallment->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}