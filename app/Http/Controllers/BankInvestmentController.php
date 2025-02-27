<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankInvestment;

class BankInvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bankInvestments = BankInvestment::all();
        return response()->json($bankInvestments);
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
            'ledger_id' => 'required|exists:ledgers,id',
            'account_id' => 'nullable|exists:accounts,id',
            'depo_account_id' => 'nullable|exists:deposit_accounts,id',
            'name' => 'required|string|max:255',
            'investment_type' => 'required|in:FD,RD,Other',
            'interest_rate' => 'required|numeric|min:0',
            'opening_date' => 'required|date',
            'opening_balance' => 'required|numeric|min:0',
            'current_balance' => 'required|numeric|min:0',
            'maturity_date' => 'required|date',
            'deposit_term_days' => 'nullable|integer',
            'months' => 'nullable|integer',
            'years' => 'nullable|integer',
            'fd_amount' => 'nullable|numeric|min:0',
            'monthly_deposit' => 'nullable|numeric|min:0',
            'rd_term_months' => 'nullable|integer',
            'maturity_amount' => 'required|numeric|min:0',
            'interest' => 'required|numeric|min:0',
            'interest_receivable' => 'required|numeric|min:0',
            'interest_frequency' => 'nullable|string|max:255'
        ]);
        
        $bankInvestment = BankInvestment::create($request->all());
        return response()->json($bankInvestment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $bankInvestment = BankInvestment::findOrFail($id);
        return response()->json($bankInvestment);
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
        $bankInvestment = BankInvestment::findOrFail($id);

        $request->validate([
            'investment_type' => 'in:FD,RD,Other',
            'interest_rate' => 'numeric|min:0',
            'opening_date' => 'date',
            'opening_balance' => 'numeric|min:0',
            'current_balance' => 'numeric|min:0',
            'maturity_date' => 'date',
            'deposit_term_days' => 'nullable|integer',
            'months' => 'nullable|integer',
            'years' => 'nullable|integer',
            'fd_amount' => 'nullable|numeric|min:0',
            'monthly_deposit' => 'nullable|numeric|min:0',
            'rd_term_months' => 'nullable|integer',
            'maturity_amount' => 'numeric|min:0',
            'interest' => 'numeric|min:0',
            'interest_receivable' => 'numeric|min:0',
            'interest_frequency' => 'nullable|string|max:255'
        ]);

        $bankInvestment->update($request->all());
        return response()->json($bankInvestment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $bankInvestment = BankInvestment::findOrFail($id);
        $bankInvestment->delete();
        return response()->json(['message' => 'Bank investment deleted successfully']);
    }
}