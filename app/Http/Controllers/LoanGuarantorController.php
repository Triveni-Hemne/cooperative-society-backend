<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanGuarantor;

class LoanGuarantorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $loanGuarantors = LoanGuarantor::with(['loan', 'member'])->get();
        return response()->json($loanGuarantors);
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
            'member_id' => 'required|exists:members,id',
            'guarantor_type' => 'required|in:Primary,Secondary,Tertiary',
            'status' => 'required|in:Active,Released',
            'added_on' => 'required|date',
            'released_on' => 'nullable|date',
        ]);

        $loanGuarantor = LoanGuarantor::create($request->all());
        return response()->json($loanGuarantor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loanGuarantor = LoanGuarantor::with(['loan', 'member'])->findOrFail($id);
        return response()->json($loanGuarantor);
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
        $loanGuarantor = LoanGuarantor::findOrFail($id);

        $request->validate([
            'guarantor_type' => 'in:Primary,Secondary,Tertiary',
            'status' => 'in:Active,Released',
            'released_on' => 'nullable|date',
        ]);

        $loanGuarantor->update($request->all());
        return response()->json($loanGuarantor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loanGuarantor = LoanGuarantor::findOrFail($id);
        $loanGuarantor->delete();
        return response()->json(['message' => 'Guarantor removed successfully']);
    
    }
}