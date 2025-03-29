<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoucherEntry;
use App\Models\GeneralLedger;
use App\Models\Account;
use App\Models\MemberDepoAccount;
use App\Models\MemberLoanAccount;
use App\Models\User;
use App\Models\Branch;

class VoucherEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voucherEntries = VoucherEntry::paginate(5);
        $ledgers = GeneralLedger::all();
        $accounts = Account::all();
        $depoAccounts = MemberDepoAccount::all();
        $loanAccounts = MemberLoanAccount::all();
        $users = User::all();
        $branches = Branch::all();
        return view('transactions.voucher-entry.list', compact('voucherEntries', 'ledgers','accounts','depoAccounts','loanAccounts','users','branches'));
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
            'transaction_type' => 'required|in:Receipt,Payment,Journal, Deposit,Withdrawal,Expense,Contra',
            'voucher_num' => 'nullable|string|max:50|unique:voucher_entries,voucher_num',
            'token_number' => 'nullable|string|max:50|unique:voucher_entries,token_number',
            'serial_no' => 'nullable|string|max:50|unique:voucher_entries,serial_no',
            'date' => 'required|date',
            'receipt_id' => 'nullable|string|max:50|unique:voucher_entries,receipt_id',
            'payment_id' => 'nullable|string|max:50|unique:voucher_entries,payment_id',
            'ledger_id' => 'required|exists:general_ledgers,id',
            'account_id' => 'nullable|exists:accounts,id',
            'member_depo_account_id' => 'nullable|exists:member_depo_accounts,id',
            'member_loan_account_id' => 'nullable|exists:member_loan_accounts,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'opening_balance' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string',
            'status' => 'required|in:Pending,Approved,Rejected'
        ]);
        
        $voucherEntry = VoucherEntry::create($request->all());
        return redirect()->back()->with('success', 'Voucher Entry  acreated successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $voucherEntry = VoucherEntry::find($id);
        if (!$voucherEntry) return response()->json(['message' => 'Voucher entry not found'], 404);
        return response()->json($voucherEntry, 200);
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
        $voucherEntry = VoucherEntry::find($id);
        if (!$voucherEntry) return response()->json(['message' => 'Voucher entry not found'], 404);

         $request->validate([
            'transaction_type' => 'required|in:Receipt,Payment,Journal,Deposit,Withdrawal,Expense,Contra',
            'voucher_num' => 'nullable|string|max:50|unique:voucher_entries,voucher_num,' . $voucherEntry->id,
            'token_number' => 'nullable|string|max:50|unique:voucher_entries,token_number,' . $voucherEntry->id,
            'serial_no' => 'nullable|string|max:50|unique:voucher_entries,serial_no,' . $voucherEntry->id,
            'date' => 'required|date',
            'receipt_id' => 'nullable|string|max:50|unique:voucher_entries,receipt_id,' . $voucherEntry->id,
            'payment_id' => 'nullable|string|max:50|unique:voucher_entries,payment_id,' . $voucherEntry->id,
            'ledger_id' => 'required|exists:general_ledgers,id',
            'account_id' => 'nullable|exists:accounts,id',
            'member_depo_account_id' => 'nullable|exists:member_depo_accounts,id',
            'member_loan_account_id' => 'nullable|exists:member_loan_accounts,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'opening_balance' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string',
            'status' => 'required|in:Pending,Approved,Rejected'
        ]);

        $voucherEntry->update($request->all());
        return redirect()->back()->with('success', 'Voucher Entry updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucherEntry = VoucherEntry::find($id);
        if (!$voucherEntry) return response()->json(['message' => 'Voucher entry not found'], 404);

        $voucherEntry->delete();
        return redirect()->back()->with('success', 'Voucher Entry deleted successfully');
    }
}