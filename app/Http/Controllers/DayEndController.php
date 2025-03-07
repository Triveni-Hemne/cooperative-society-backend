<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DayEnd;

class DayEndController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    //    return response()->json(DayEnd::all(), 200);
    return view('transactions.day-ends.list');
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
            'date' => 'required|date',
            'opening_cash' => 'required|numeric',
            'total_credit_rs' => 'required|numeric',
            'total_credit_chalans' => 'required|integer',
            'total_debit_rs' => 'required|numeric',
            'total_debit_challans' => 'required|integer'
        ]);

        $dayEnd = DayEnd::create($request->all());
        return response()->json($dayEnd, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $dayEnd = DayEnd::find($id);
        if (!$dayEnd) return response()->json(['message' => 'Day end not found'], 404);
        return response()->json($dayEnd, 200);
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
        $dayEnd = DayEnd::find($id);
        if (!$dayEnd) return response()->json(['message' => 'Day end not found'], 404);

        $request->validate([
            'date' => 'date',
            'opening_cash' => 'numeric',
            'total_credit_rs' => 'numeric',
            'total_credit_chalans' => 'integer',
            'total_debit_rs' => 'numeric',
            'total_debit_challans' => 'integer'
        ]);

        $dayEnd->update($request->all());
        return response()->json($dayEnd, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $dayEnd = DayEnd::find($id);
        if (!$dayEnd) return response()->json(['message' => 'Day end not found'], 404);

        $dayEnd->delete();
        return response()->json(['message' => 'Day end deleted'], 200);
    }
}