<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralLedger;
use Illuminate\Validation\Rule;

class GeneralLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $generalLedgers = GeneralLedger::with('schedule')->get();
        return response()->json($generalLedgers);
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
        $validated = $request->validate([
            'parent_ledger_id' => 'nullable|exists:general_ledgers,id',
            'name' => 'string|max:255',
            'type' => 'in:Assets,Liability,Income,Expense',
            'balance' => 'numeric|min:0',
            'open_balance' => 'numeric|min:0',
            'min_amount' => 'numeric|min:0',
            'subsidiary' => 'boolean',
            'group' => 'nullable|string|max:255',
            'demand' => 'boolean',
            'type_detail' => 'in:Bank,Loan,Investment,Member,Deposit',
            'gl_type' => 'in:Asset,Liability,Income,Expense',
            'item_of' => 'nullable|string|max:255'
        ]);

        $generalLedger = GeneralLedger::create($validated);
        return response()->json(['message' => 'General Ledger added successfully', 'generalLedger' => $generalLedger], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $generalLedger = GeneralLedger::with('schedule')->findOrFail($id);
        return response()->json($generalLedger);
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
        $generalLedger = GeneralLedger::findOrFail($id);

        $validated = $request->validate([
            'parent_ledger_id' => 'nullable|exists:general_ledgers,id',
            'name' => 'string|max:255',
            'type' => 'in:Assets,Liability,Income,Expense',
            'balance' => 'numeric|min:0',
            'open_balance' => 'numeric|min:0',
            'min_amount' => 'numeric|min:0',
            'subsidiary' => 'boolean',
            'group' => 'nullable|string|max:255',
            'demand' => 'boolean',
            'type_detail' => 'in:Bank,Loan,Investment,Member,Deposit',
            'gl_type' => 'in:Asset,Liability,Income,Expense',
            'item_of' => 'nullable|string|max:255'
        ]);

        $generalLedger->update($validated);
        return response()->json(['message' => 'General Ledger updated successfully', 'generalLedger' => $generalLedger]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $generalLedger = GeneralLedger::findOrFail($id);
        $generalLedger->delete();
        return response()->json(['message' => 'General Ledger deleted successfully']);
    }
}