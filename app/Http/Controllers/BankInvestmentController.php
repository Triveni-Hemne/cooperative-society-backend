<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankInvestment;

class BankInvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bankInvestments = BankInvestment::all();
        return response()->json($bankInvestments);
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
            'deopsite_account_id' => 'required|exists:member_depo_accounts,id',
            'fd_term_months' => 'required|integer|min:1',
            'maturity_amount' => 'nullable|numeric|min:0',
        ]);
        
        $bankInvestment = BankInvestment::create($request->all());
        return response()->json($bankInvestment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $bankInvestment = BankInvestment::findOrFail($id);
        return response()->json($bankInvestment);
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
        $bankInvestment = BankInvestment::findOrFail($id);

        $request->validate([
            'deopsite_account_id' => 'sometimes|exists:member_depo_accounts,id',
            'fd_term_months' => 'sometimes|integer|min:1',
            'maturity_amount' => 'nullable|numeric|min:0',
        ]);

        $bankInvestment->update($request->all());
        return response()->json($bankInvestment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $bankInvestment = BankInvestment::findOrFail($id);
        $bankInvestment->delete();
        return response()->json(['message' => 'Bank investment deleted successfully']);
    }
}