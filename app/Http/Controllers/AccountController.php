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
            'account_no' => 'required|unique:accounts,account_no|max:50',
            'name' => 'required|max:255',
            'account_type' => 'required|in:Deposit,Loan,Savings,Investment',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'open_balance' => 'nullable|numeric|min:0',
            'balance' => 'nullable|numeric|min:0',
            'closing_flag' => 'boolean',
            'add_to_demand' => 'boolean',
            'agent_id' => 'nullable|exists:agents,id',
            'installment_type' => 'nullable|in:Monthly,Quarterly,Yearly',
            'installment_amount' => 'nullable|numeric|min:0',
            'total_installments_paid' => 'integer|min:0',
            'closing_date' => 'nullable|date|after_or_equal:start_date',
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
            'ledger_id' => 'sometimes|exists:general_ledgers,id',
            'member_id' => 'sometimes|nullable|exists:members,id',
            'account_no' => 'sometimes|unique:accounts,account_no,'.$id.'|max:50',
            'name' => 'sometimes|max:255',
            'account_type' => 'sometimes|in:Deposit,Loan,Savings,Investment',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'start_date' => 'sometimes|date',
            'open_balance' => 'nullable|numeric|min:0',
            'balance' => 'nullable|numeric|min:0',
            'closing_flag' => 'boolean',
            'add_to_demand' => 'boolean',
            'agent_id' => 'nullable|exists:agents,id',
            'installment_type' => 'nullable|in:Monthly,Quarterly,Yearly',
            'installment_amount' => 'nullable|numeric|min:0',
            'total_installments_paid' => 'integer|min:0',
            'closing_date' => 'nullable|date|after_or_equal:start_date',
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