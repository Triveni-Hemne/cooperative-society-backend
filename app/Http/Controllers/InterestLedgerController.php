<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InterestLedger;

class InterestLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(InterestLedger::with(['generalLedger', 'transaction'])->orderBy('interest_applied_date', 'desc')->get());
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
            'general_ledger_id' => 'required|exists:general_ledgers,id',
            'transaction_id' => 'required|exists:installment_transactions,id',
            'interest_rate' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'interest_applied_date' => 'required|date'
        ]);

        $interestLedger = InterestLedger::create($request->all());
        return response()->json($interestLedger, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $interestLedger = InterestLedger::with(['generalLedger', 'transaction'])->findOrFail($id);
        return response()->json($interestLedger);
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
        $interestLedger = InterestLedger::findOrFail($id);

        $request->validate([
            'general_ledger_id' => 'sometimes|exists:general_ledgers,id',
            'transaction_id' => 'sometimes|exists:installment_transactions,id',
            'interest_rate' => 'sometimes|numeric|min:0',
            'amount' => 'sometimes|numeric|min:0',
            'interest_applied_date' => 'sometimes|date'
        ]);

        $interestLedger->update($request->all());
        return response()->json($interestLedger);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $interestLedger = InterestLedger::findOrFail($id);
        $interestLedger->delete();
        return response()->json(['message' => 'Interest ledger entry deleted successfully']);
    }
}