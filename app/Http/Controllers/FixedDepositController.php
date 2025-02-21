<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FixedDeposit;

class FixedDepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return response()->json(FixedDeposit::all(), 200);
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
            'deposit_account_id' => 'required|exists:deposit_accounts,id',
            'fd_term_months' => 'required|integer|min:1',
            'maturity_amount' => 'nullable|numeric|min:0'
        ]);

        $fixedDeposit = FixedDeposit::create($request->all());
        return response()->json($fixedDeposit, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fixedDeposit = FixedDeposit::find($id);
        if (!$fixedDeposit) return response()->json(['message' => 'Fixed deposit not found'], 404);
        return response()->json($fixedDeposit, 200);
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
        $fixedDeposit = FixedDeposit::find($id);
        if (!$fixedDeposit) return response()->json(['message' => 'Fixed deposit not found'], 404);

        $request->validate([
            'fd_term_months' => 'integer|min:1',
            'maturity_amount' => 'nullable|numeric|min:0'
        ]);

        $fixedDeposit->update($request->all());
        return response()->json($fixedDeposit, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fixedDeposit = FixedDeposit::find($id);
        if (!$fixedDeposit) return response()->json(['message' => 'Fixed deposit not found'], 404);

        $fixedDeposit->delete();
        return response()->json(['message' => 'Fixed deposit deleted'], 200);
    }
}