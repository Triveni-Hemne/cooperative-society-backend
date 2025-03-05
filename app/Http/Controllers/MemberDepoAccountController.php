<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberDepoAccount;


class MemberDepoAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = MemberDepoAccount::all();
        // return response()->json($accounts);
        return view('accounts.deposit-acc-opening.list');

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
           'ledger_id' => 'nullable|exists:ledgers,id',
            'account_id' => 'nullable|exists:accounts,id',
            'member_id' => 'nullable|exists:members,id',
            'acc_no' => 'required|string|max:50|unique:member_depo_accounts',
            'deposit_type' => 'required|in:Savings,Fixed Deposit,Recurring Deposit',
            'name' => 'required|string|max:255',
            'interest_rate' => 'required|numeric|min:0',
            'ac_start_date' => 'required|date',
            'open_balance' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'closing_flag' => 'boolean',
            'add_to_demand' => 'boolean',
            'agent_id' => 'nullable|exists:agents,id',
            'page_no' => 'nullable|string|max:50',
            'installment_type' => 'nullable|in:Monthly,Quarterly,Yearly',
            'installment_amount' => 'nullable|numeric|min:0',
            'total_installments' => 'nullable|integer|min:0',
            'total_payable_amount' => 'nullable|numeric|min:0',
            'total_installments_paid' => 'integer|min:0',
            'account_closing_date' => 'nullable|date',
            'interest_payable' => 'nullable|numeric|min:0',
            'open_interest' => 'nullable|numeric|min:0'
        ]);

        $account = MemberDepoAccount::create($request->all());
        return response()->json($account, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $account = MemberDepoAccount::findOrFail($id);
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
        $account = MemberDepoAccount::findOrFail($id);

        $request->validate([
            'ledger_id' => 'nullable|exists:ledgers,id',
            'account_id' => 'nullable|exists:accounts,id',
            'member_id' => 'nullable|exists:members,id',
            'acc_no' => 'required|string|max:50|unique:member_depo_accounts',
            'deposit_type' => 'required|in:Savings,Fixed Deposit,Recurring Deposit',
            'name' => 'required|string|max:255',
            'interest_rate' => 'required|numeric|min:0',
            'ac_start_date' => 'required|date',
            'open_balance' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'closing_flag' => 'boolean',
            'add_to_demand' => 'boolean',
            'agent_id' => 'nullable|exists:agents,id',
            'page_no' => 'nullable|string|max:50',
            'installment_type' => 'nullable|in:Monthly,Quarterly,Yearly',
            'installment_amount' => 'nullable|numeric|min:0',
            'total_installments' => 'nullable|integer|min:0',
            'total_payable_amount' => 'nullable|numeric|min:0',
            'total_installments_paid' => 'integer|min:0',
            'account_closing_date' => 'nullable|date',
            'interest_payable' => 'nullable|numeric|min:0',
            'open_interest' => 'nullable|numeric|min:0'
        ]);

        $account->update($request->all());
        return response()->json($account);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $account = MemberDepoAccount::findOrFail($id);
        $account->delete();
        return response()->json(['message' => 'Member deposit account deleted successfully']);
    }
}