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
            'ledger_id' => 'required|exists:general_ledgers,id',
            'member_id' => 'required|exists:members,id',
            'acc_no' => 'required|string|max:50|unique:member_loan_accounts',
            'name' => 'required|string|max:255',
            'ac_start_date' => 'required|date',
            'open_balance' => 'required|numeric',
            'purpose' => 'required|in:Agriculture,Construction,Cottage,SSI Unit,Dairy',
            'interest_rate' => 'required|numeric',
            'balance' => 'required|numeric',
            'loan_amount' => 'required|numeric',
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
            'ledger_id' => 'required|exists:general_ledgers,id',
            'member_id' => 'required|exists:members,id',
            'acc_no' => 'required|string|max:50|unique:member_loan_accounts,acc_no,' . $memberLoanAccount->id,
            'name' => 'required|string|max:255',
            'ac_start_date' => 'required|date',
            'open_balance' => 'required|numeric',
            'purpose' => 'required|in:Agriculture,Construction,Cottage,SSI Unit,Dairy',
            'interest_rate' => 'required|numeric',
            'balance' => 'required|numeric',
            'loan_amount' => 'required|numeric',
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