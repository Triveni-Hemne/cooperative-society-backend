<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StandingInstruction;

class StandingInstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json(StandingInstruction::all(), 200);
        return view('accounts.standing-instruction.list');
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
            'credit_ledger_id' => 'nullable|exists:ledgers,id',
            'credit_account_id' => 'nullable|exists:accounts,id',
            'credit_transfer' => 'nullable|numeric|min:0',
            'debit_ledger_id' => 'nullable|exists:ledgers,id',
            'debit_account_id' => 'nullable|exists:accounts,id',
            'debit_transfer' => 'nullable|numeric|min:0',
            'date' => 'required|date',
            'frequency' => 'required|in:Daily,Weekly,Monthly,Quarterly,Yearly',
            'no_of_times' => 'required|integer|min:1',
            'bal_installment' => 'required|integer|min:0',
            'execution_date' => 'required|date',
            'amount' => 'required|numeric|min:0'
        ]);

        $standingInstruction = StandingInstruction::create($request->all());
        return response()->json($standingInstruction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $standingInstruction = StandingInstruction::find($id);
        if (!$standingInstruction) return response()->json(['message' => 'Not Found'], 404);
        return response()->json($standingInstruction, 200);
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
       $standingInstruction = StandingInstruction::find($id);
        if (!$standingInstruction) return response()->json(['message' => 'Not Found'], 404);

        $request->validate([
            'credit_transfer' => 'nullable|numeric|min:0',
            'debit_transfer' => 'nullable|numeric|min:0',
            'date' => 'date',
            'frequency' => 'in:Daily,Weekly,Monthly,Quarterly,Yearly',
            'no_of_times' => 'integer|min:1',
            'bal_installment' => 'integer|min:0',
            'execution_date' => 'date',
            'amount' => 'numeric|min:0'
        ]);

        $standingInstruction->update($request->all());
        return response()->json($standingInstruction, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $standingInstruction = StandingInstruction::find($id);
        if (!$standingInstruction) return response()->json(['message' => 'Not Found'], 404);

        $standingInstruction->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}