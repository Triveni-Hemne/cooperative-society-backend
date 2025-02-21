<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Receipt;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Receipt::with(['payment', 'member', 'depositAccount', 'account', 'loanAccount', 'issuedBy'])->get(), 200);
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
            'payment_id' => 'required|exists:payments,id',
            'member_id' => 'nullable|exists:users,id',
            'member_depo_account_id' => 'nullable|exists:accounts,id',
            'account_id' => 'nullable|exists:accounts,id',
            'member_loan_account_id' => 'nullable|exists:loans,id',
            'receipt_no' => 'required|string|max:50|unique:receipts,receipt_no',
            'issued_by' => 'required|exists:users,id',
            'issue_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:Cash,Bank Transfer,Cheque'
        ]);

        $receipt = Receipt::create($request->all());
        return response()->json($receipt, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $receipt = Receipt::with(['payment', 'member', 'depositAccount', 'account', 'loanAccount', 'issuedBy'])->find($id);
        if (!$receipt) return response()->json(['message' => 'Receipt not found'], 404);
        return response()->json($receipt, 200);
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
        $receipt = Receipt::find($id);
        if (!$receipt) return response()->json(['message' => 'Receipt not found'], 404);

        $request->validate([
            'receipt_no' => 'string|max:50|unique:receipts,receipt_no,' . $id,
            'issue_date' => 'date',
            'amount' => 'numeric|min:0.01',
            'method' => 'in:Cash,Bank Transfer,Cheque'
        ]);

        $receipt->update($request->all());
        return response()->json($receipt, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $receipt = Receipt::find($id);
        if (!$receipt) return response()->json(['message' => 'Receipt not found'], 404);

        $receipt->delete();
        return response()->json(['message' => 'Receipt deleted'], 200);

    }
}