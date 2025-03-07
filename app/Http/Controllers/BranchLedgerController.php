<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BranchLedger;

class BranchLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //  return response()->json(BranchLedger::all(), 200);
        return view('transactions.branch-ledger.list');
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
            'branch_code' => 'required|string|max:20',
            'gl_id' => 'required|exists:general_ledgers,id',
            'open_date' => 'required|date',
            'open_balance' => 'required|numeric',
            'balance' => 'required|numeric',
            'balance_type' => 'required|in:Credit,Debit',
            'item_type' => 'required|in:Asset,Liability,Income,Expense'
        ]);

        $branchLedger = BranchLedger::create($request->all());
        return response()->json($branchLedger, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $branchLedger = BranchLedger::find($id);
        if (!$branchLedger) return response()->json(['message' => 'Branch ledger not found'], 404);
        return response()->json($branchLedger, 200);
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
         $branchLedger = BranchLedger::find($id);
        if (!$branchLedger) return response()->json(['message' => 'Branch ledger not found'], 404);

        $request->validate([
            'branch_code' => 'string|max:20',
            'gl_id' => 'exists:general_ledgers,id',
            'open_date' => 'date',
            'open_balance' => 'numeric',
            'balance' => 'numeric',
            'balance_type' => 'in:Credit,Debit',
            'item_type' => 'in:Asset,Liability,Income,Expense'
        ]);

        $branchLedger->update($request->all());
        return response()->json($branchLedger, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $branchLedger = BranchLedger::find($id);
        if (!$branchLedger) return response()->json(['message' => 'Branch ledger not found'], 404);

        $branchLedger->delete();
        return response()->json(['message' => 'Branch ledger deleted'], 200);
    }
}