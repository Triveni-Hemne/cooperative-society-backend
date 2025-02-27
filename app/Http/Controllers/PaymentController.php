<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Payment::with(['member', 'depositAccount', 'account', 'loanAccount'])->get(), 200);
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
            'member_id' => 'nullable|exists:users,id',
            'member_depo_account_id' => 'nullable|exists:accounts,id',
            'account_id' => 'nullable|exists:accounts,id',
            'member_loan_account_id' => 'nullable|exists:loans,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'method' => 'required|in:Cash,Bank Transfer,Cheque',
            'status' => 'required|in:Pending,Completed,Failed'
        ]);

        $payment = Payment::create($request->all());
        return response()->json($payment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with(['member', 'depositAccount', 'account', 'loanAccount'])->find($id);
        if (!$payment) return response()->json(['message' => 'Payment not found'], 404);
        return response()->json($payment, 200);
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
        $payment = Payment::find($id);
        if (!$payment) return response()->json(['message' => 'Payment not found'], 404);

        $request->validate([
            'amount' => 'numeric|min:0.01',
            'payment_date' => 'date',
            'method' => 'in:Cash,Bank Transfer,Cheque',
            'status' => 'in:Pending,Completed,Failed'
        ]);

        $payment->update($request->all());
        return response()->json($payment, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::find($id);
        if (!$payment) return response()->json(['message' => 'Payment not found'], 404);

        $payment->delete();
        return response()->json(['message' => 'Payment deleted'], 200);
    }
}