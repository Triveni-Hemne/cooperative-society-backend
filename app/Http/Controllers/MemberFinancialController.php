<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberFinancial;

class MemberFinancialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $financials = MemberFinancial::all();
        return response()->json($financials);
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
          'share_amount' => 'numeric|min:0',
            'welfare_fund' => 'nullable|numeric|min:0',
            'page_no' => 'nullable|string|max:50',
            'current_balance' => 'numeric|min:0',
            'monthly_balance' => 'numeric|min:0',
            'dividend_amount' => 'nullable|numeric|min:0',
            'monthly_deposit' => 'numeric|min:0',
            'demand' => 'nullable|numeric|min:0',
            'type' => 'in:Share,Dividend,Deposit'
        ]);

        $financial = MemberFinancial::create($request->all());
        return response()->json($financial, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $financial = MemberFinancial::findOrFail($id);
        return response()->json($financial);
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
         $financial = MemberFinancial::findOrFail($id);

        $request->validate([
            'share_amount' => 'numeric|min:0',
            'welfare_fund' => 'nullable|numeric|min:0',
            'page_no' => 'nullable|string|max:50',
            'current_balance' => 'numeric|min:0',
            'monthly_balance' => 'numeric|min:0',
            'dividend_amount' => 'nullable|numeric|min:0',
            'monthly_deposit' => 'numeric|min:0',
            'demand' => 'nullable|numeric|min:0',
            'type' => 'in:Share,Dividend,Deposit'
        ]);

        $financial->update($request->all());
        return response()->json($financial);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $financial = MemberFinancial::findOrFail($id);
        $financial->delete();
        return response()->json(['message' => 'Member financial record deleted successfully']);
    }
}