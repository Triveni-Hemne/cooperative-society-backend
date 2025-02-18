<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScheduleLedger;
use Illuminate\Validation\Rule;

class ScheduleLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scheduleLedgers = ScheduleLedger::all();
        return response()->json($scheduleLedgers);  
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
            'name' => 'required|string|max:255|unique:schedule_ledgers,name',
            'type' => ['required', Rule::in(['Assets', 'Liability', 'Income', 'Expense'])],
        ]);

        $scheduleLedger = ScheduleLedger::create($validated);
        return response()->json(['message' => 'Schedule Ledger added successfully', 'scheduleLedger' => $scheduleLedger], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $scheduleLedger = ScheduleLedger::findOrFail($id);
        return response()->json($scheduleLedger);
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
        $scheduleLedger = ScheduleLedger::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('schedule_ledgers')->ignore($scheduleLedger->id)],
            'type' => ['required', Rule::in(['Assets', 'Liability', 'Income', 'Expense'])],
        ]);

        $scheduleLedger->update($validated);
        return response()->json(['message' => 'Schedule Ledger updated successfully', 'scheduleLedger' => $scheduleLedger]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $scheduleLedger = ScheduleLedger::findOrFail($id);
        $scheduleLedger->delete();
        return response()->json(['message' => 'Schedule Ledger deleted successfully']);
    }
}