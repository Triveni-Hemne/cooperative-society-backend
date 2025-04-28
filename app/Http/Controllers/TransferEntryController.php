<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransferEntry;
use App\Models\GeneralLedger;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class TransferEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $branchId = null;
        // Determine branch filter based on role
        if ($user->role === 'Admin') {
            $branchId = $request->branch_id; // admin can filter via dropdown
        } else {
            $branchId = $user->branch_id; // normal user only sees their branch
        }
        $transferEntries = TransferEntry::with('user')
        ->when($branchId, function ($query) use ($branchId) {
                $query->where(function ($query) use ($branchId) {
                    $query->whereHas('user', function ($q) use ($branchId) {
                        $q->where('branch_id', $branchId);
                    })->orWhereHas('branch', function ($q) use ($branchId) {
                        $q->where('id', $branchId);
                    });
                });
            })->paginate(5);
        $ledgers = GeneralLedger::all();
        $user = Auth::user();
        $branches = $user->role === 'Admin' ? Branch::all() : null;
        return view('transactions.transfer-entry.list', compact('transferEntries','ledgers','user','branches'));
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
            'branch_id' => 'nullable|exists:branches,id',
            'opening_balance' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string',
            'created_by' => 'nullable|exists:users,id',

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
            'branch_id' => 'nullable|exists:branches,id',
            'opening_balance' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'narration' => 'nullable|string',
            'm_narration' => 'nullable|string',
            'created_by' => 'required|exists:users,id',


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