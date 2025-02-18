<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InstallmentTransaction;

class InstallmentTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = InstallmentTransaction::all();
        return response()->json($transactions);
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
            'deposit_account_id' => 'required|exists:member_depo_accounts,id',
            'installment_no' => 'required|integer|min:1',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'interest_earned' => 'nullable|numeric|min:0',
            'total_balance' => 'required|numeric|min:0',
        ]);

        $transaction = InstallmentTransaction::create($request->all());
        return response()->json($transaction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = InstallmentTransaction::findOrFail($id);
        return response()->json($transaction);
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
       $transaction = InstallmentTransaction::findOrFail($id);

        $request->validate([
            'deposit_account_id' => 'sometimes|exists:member_depo_accounts,id',
            'installment_no' => 'sometimes|integer|min:1',
            'amount_paid' => 'sometimes|numeric|min:0',
            'payment_date' => 'sometimes|date',
            'interest_earned' => 'nullable|numeric|min:0',
            'total_balance' => 'sometimes|numeric|min:0',
        ]);

        $transaction->update($request->all());
        return response()->json($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = InstallmentTransaction::findOrFail($id);
        $transaction->delete();
        return response()->json(['message' => 'Installment transaction deleted successfully']);
    }
}