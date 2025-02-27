<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::all();
        return response()->json($accounts);
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
            'ledger_id' => 'required|exists:general_ledgers,id',
            'member_id' => 'nullable|exists:members,id',
            'account_no' => 'required|string|max:50|unique:accounts,account_no',
            'account_name' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'account_type' => 'required|in:Deposit,Loan,Savings,Investment',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'open_balance' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'closing_flag' => 'boolean',
            'add_to_demand' => 'boolean',
            'agent_id' => 'nullable|exists:members,id',
            'installment_type' => 'nullable|in:Monthly,Quarterly,Yearly',
            'installment_amount' => 'nullable|numeric|min:0',
            'total_installments_paid' => 'required|integer|min:0',
            'closing_date' => 'nullable|date'
        ]);

        $account = Account::create($request->all());
        return response()->json($account, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $account = Account::findOrFail($id);
        return response()->json($account);
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
        $account = Account::findOrFail($id);

        $request->validate([
            'ledger_id' => 'required|exists:general_ledgers,id',
            'member_id' => 'nullable|exists:members,id',
            'account_no' => 'required|string|max:50|unique:accounts,account_no',
            'account_name' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'account_type' => 'required|in:Deposit,Loan,Savings,Investment',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'open_balance' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'closing_flag' => 'boolean',
            'add_to_demand' => 'boolean',
            'agent_id' => 'nullable|exists:members,id',
            'installment_type' => 'nullable|in:Monthly,Quarterly,Yearly',
            'installment_amount' => 'nullable|numeric|min:0',
            'total_installments_paid' => 'required|integer|min:0',
            'closing_date' => 'nullable|date'
        ]);

        $account->update($request->all());
        return response()->json($account);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $account = Account::findOrFail($id);
        $account->delete();
        return response()->json(['message' => 'Account deleted successfully']);
    }
}