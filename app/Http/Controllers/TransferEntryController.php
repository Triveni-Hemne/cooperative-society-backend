<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransferEntry;

class TransferEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return response()->json(TransferEntry::all(), 200);
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
            'transaction_type' => 'required|in:Credit,Debit,Journal',
            'date' => 'required|date',
            'receipt_id' => 'nullable|string|max:50',
            'payment_id' => 'nullable|string|max:50',
            'ledger_id' => 'required|exists:ledgers,id',
            'opening_balance' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string'
        ]);

        $transferEntry = TransferEntry::create($request->all());
        return response()->json($transferEntry, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transferEntry = TransferEntry::find($id);
        if (!$transferEntry) return response()->json(['message' => 'Transfer entry not found'], 404);
        return response()->json($transferEntry, 200);
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
       $transferEntry = TransferEntry::find($id);
        if (!$transferEntry) return response()->json(['message' => 'Transfer entry not found'], 404);

        $request->validate([
            'transaction_type' => 'in:Credit,Debit,Journal',
            'date' => 'date',
            'receipt_id' => 'string|max:50',
            'payment_id' => 'string|max:50',
            'ledger_id' => 'exists:ledgers,id',
            'opening_balance' => 'numeric',
            'current_balance' => 'numeric',
            'narration' => 'string',
            'm_narration' => 'string'
        ]);

        $transferEntry->update($request->all());
        return response()->json($transferEntry, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $transferEntry = TransferEntry::find($id);
        if (!$transferEntry) return response()->json(['message' => 'Transfer entry not found'], 404);

        $transferEntry->delete();
        return response()->json(['message' => 'Transfer entry deleted'], 200);
    }
}