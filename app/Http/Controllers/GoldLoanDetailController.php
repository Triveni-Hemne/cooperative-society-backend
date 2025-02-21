<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoldLoanDetail;

class GoldLoanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(GoldLoanDetail::all(), 200);
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
            'loan_id' => 'required|exists:loans,id',
            'gold_weight' => 'required|numeric|min:0.01',
            'gold_purity' => 'required|in:18K,22K,24K',
            'market_value' => 'required|numeric|min:0',
            'pledged_date' => 'required|date',
            'release_status' => 'in:Pledged,Released',
            'release_date' => 'nullable|date|after_or_equal:pledged_date'
        ]);

        $goldLoanDetail = GoldLoanDetail::create($request->all());
        return response()->json($goldLoanDetail, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $goldLoanDetail = GoldLoanDetail::find($id);
        if (!$goldLoanDetail) return response()->json(['message' => 'Gold loan detail not found'], 404);
        return response()->json($goldLoanDetail, 200);
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
        $goldLoanDetail = GoldLoanDetail::find($id);
        if (!$goldLoanDetail) return response()->json(['message' => 'Gold loan detail not found'], 404);

        $request->validate([
            'gold_weight' => 'numeric|min:0.01',
            'gold_purity' => 'in:18K,22K,24K',
            'market_value' => 'numeric|min:0',
            'release_status' => 'in:Pledged,Released',
            'release_date' => 'nullable|date|after_or_equal:pledged_date'
        ]);

        $goldLoanDetail->update($request->all());
        return response()->json($goldLoanDetail, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $goldLoanDetail = GoldLoanDetail::find($id);
        if (!$goldLoanDetail) return response()->json(['message' => 'Gold loan detail not found'], 404);

        $goldLoanDetail->delete();
        return response()->json(['message' => 'Gold loan detail deleted'], 200);
    }
}