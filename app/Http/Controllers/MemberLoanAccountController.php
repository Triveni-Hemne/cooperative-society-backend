<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberLoanAccount;
use App\Models\Member;
use App\Models\GeneralLedger;


class MemberLoanAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $loanAccounts = MemberLoanAccount::with(['member', 'ledger'])->get();
        return $loanAccounts;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $members = Member::all();
        $ledgers = GeneralLedger::all();
        return $ledgers;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
            'ledger_id' => 'required|exists:ledgers,id',
            'member_id' => 'required|exists:members,id',
            'account_id' => 'nullable|exists:accounts,id',
            'loan_type' => 'required|in:Personal Loan,Home Loan,Auto Loan,Business Loan',
            'name' => 'required|string|max:255',
            'ac_start_date' => 'required|date',
            'open_balance' => 'required|numeric|min:0',
            'purpose' => 'required|in:Agriculture,Construction,Cottage,Small Scale Industry',
            'principal_amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0',
            'tenure' => 'required|integer|min:1',
            'emi_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'balance' => 'required|numeric|min:0',
            'loan_amount' => 'required|numeric|min:0',
            'collateral_type' => 'required|in:Gold,Property,Vehicle,None',
            'collateral_value' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Closed,Defaulted',
        ]);

        MemberLoanAccount::create($request->all());

        return redirect()->route('member-loan-accounts.index')->with('success', 'Loan account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $loanAccount = MemberLoanAccount::find($id);

        if (!$loanAccount) {
            return response()->json(['message' => 'Loan account not found'], 404);
        }

        return response()->json($loanAccount, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $members = Member::all();
        $ledgers = GeneralLedger::all();
        return $ledgers;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'interest_rate' => 'numeric|min:0',
            'tenure' => 'integer|min:1',
            'balance' => 'numeric|min:0',
            'loan_amount' => 'numeric|min:0',
            'collateral_value' => 'numeric|min:0',
            'status' => 'in:Active,Closed,Defaulted',
        ]);

        $memberLoanAccount->update($request->all());

        return redirect()->route('member-loan-accounts.index')->with('success', 'Loan account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $memberLoanAccount->delete();
        return $memberLoanAccount;
    }
}