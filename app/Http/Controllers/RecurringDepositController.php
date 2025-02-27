<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecurringDeposit;

class RecurringDepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $recurringDeposits = RecurringDeposit::all();
        return response()->json($recurringDeposits);
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
            'rd_term_months' => 'required|integer|min:1',
            'maturity_amount' => 'nullable|numeric|min:0'
        ]);

        $recurringDeposit = RecurringDeposit::create($request->all());
        return response()->json($recurringDeposit, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recurringDeposit = RecurringDeposit::findOrFail($id);
        return response()->json($recurringDeposit);
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
        $recurringDeposit = RecurringDeposit::findOrFail($id);

        $request->validate([
           'rd_term_months' => 'integer|min:1',
            'maturity_amount' => 'nullable|numeric|min:0'
        ]);

        $recurringDeposit->update($request->all());
        return response()->json($recurringDeposit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $recurringDeposit = RecurringDeposit::findOrFail($id);
        $recurringDeposit->delete();
        return response()->json(['message' => 'Recurring deposit deleted successfully']);
    }
}