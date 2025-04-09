<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransferEntry;
use App\Models\GeneralLedger;

class TransferEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transferEntries = TransferEntry::paginate(5);
        $ledgers = GeneralLedger::all();
        return view('transactions.transfer-entry.list', compact('transferEntries','ledgers'));
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
            'ledger_id' => 'required|exists:general_ledgers,id',
            'opening_balance' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string'
        ]);
        // return $request->all();

        $transferEntry = TransferEntry::create($request->all());
        return redirect()->back()->with('success', 'Transfer Entry Created Successfully');
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
            'transaction_type' => 'required|in:Credit,Debit,Journal',
            'date' => 'required|date',
            'receipt_id' => 'nullable|string|max:50|unique:transfer_entries,receipt_id,' . $transferEntry->id,
            'payment_id' => 'nullable|string|max:50|unique:transfer_entries,payment_id,' . $transferEntry->id,
            'ledger_id' => 'required|exists:general_ledgers,id',
            'opening_balance' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string'
        ]);

        $transferEntry->update($request->all());
        return redirect()->back()->with('success', 'Transfer Entry Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $transferEntry = TransferEntry::find($id);
        if (!$transferEntry) return response()->json(['message' => 'Transfer entry not found'], 404);

        $transferEntry->delete();
        return redirect()->back()->with('success', 'Transfer Entry Deleted Successfully');
    }
}