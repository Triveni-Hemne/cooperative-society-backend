<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoucherEntry;

class VoucherEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(VoucherEntry::all(), 200);
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
            'transaction_type' => 'required|in:Receipt,Payment,Journal,Deposit,Withdrawal,Expense,Contra',
            'voucher_num' => 'nullable|string|max:50',
            'token_number' => 'nullable|string|max:50',
            'serial_no' => 'nullable|string|max:50',
            'date' => 'required|date',
            'receipt_id' => 'nullable|string|max:50',
            'payment_id' => 'nullable|string|max:50',
            'ledger_id' => 'required|exists:ledgers,id',
            'account_id' => 'nullable|exists:accounts,id',
            'member_depo_account_id' => 'nullable|exists:member_accounts,id',
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
        return response()->json($voucherEntry, 201);
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
            'transaction_type' => 'in:Receipt,Payment,Journal,Deposit,Withdrawal,Expense,Contra',
            'voucher_num' => 'string|max:50',
            'token_number' => 'string|max:50',
            'serial_no' => 'string|max:50',
            'date' => 'date',
            'receipt_id' => 'string|max:50',
            'payment_id' => 'string|max:50',
            'ledger_id' => 'exists:ledgers,id',
            'account_id' => 'exists:accounts,id',
            'member_depo_account_id' => 'exists:member_accounts,id',
            'member_loan_account_id' => 'exists:member_loan_accounts,id',
            'from_date' => 'date',
            'to_date' => 'date',
            'opening_balance' => 'numeric',
            'current_balance' => 'numeric',
            'narration' => 'string',
            'm_narration' => 'string',
            'status' => 'in:Pending,Approved,Rejected'
        ]);

        $voucherEntry->update($request->all());
        return response()->json($voucherEntry, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucherEntry = VoucherEntry::find($id);
        if (!$voucherEntry) return response()->json(['message' => 'Voucher entry not found'], 404);

        $voucherEntry->delete();
        return response()->json(['message' => 'Voucher entry deleted'], 200);
    }
}