<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DepositNominee;


class DepositNomineeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nominees = DepositNominee::all();
        return response()->json($nominees);
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
            'deposit_account_id' => 'required|exists:member_depo_accounts,id',
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'gender' => 'required|in:Male,Female,Other',
            'relation' => 'required|string|max:100',
            'nominee_image' => 'nullable|string|max:255',
        ]);

        $nominee = DepositNominee::create($request->all());
        return response()->json($nominee, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nominee = DepositNominee::findOrFail($id);
        return response()->json($nominee);
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
        $nominee = DepositNominee::findOrFail($id);

        $request->validate([
            'deposit_account_id' => 'sometimes|exists:member_depo_accounts,id',
            'name' => 'sometimes|string|max:255',
            'age' => 'nullable|integer|min:0',
            'gender' => 'sometimes|in:Male,Female,Other',
            'relation' => 'sometimes|string|max:100',
            'nominee_image' => 'nullable|string|max:255',
        ]);

        $nominee->update($request->all());
        return response()->json($nominee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $nominee = DepositNominee::findOrFail($id);
        $nominee->delete();
        return response()->json(['message' => 'Deposit nominee deleted successfully']);
    }
}