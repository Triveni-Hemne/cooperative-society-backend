<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingAccount;

class SavingAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(SavingAccount::all(), 200);
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
            'balance' => 'numeric|min:0',
            'interest_rate' => 'numeric|min:0|max:100',
            'status' => 'in:Active,Dormant,Closed'
        ]);

        $savingAccount = SavingAccount::create($request->all());
        return response()->json($savingAccount, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $savingAccount = SavingAccount::find($id);
        if (!$savingAccount) return response()->json(['message' => 'Saving account not found'], 404);
        return response()->json($savingAccount, 200);
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
       $savingAccount = SavingAccount::find($id);
        if (!$savingAccount) return response()->json(['message' => 'Saving account not found'], 404);

        $request->validate([
            'balance' => 'numeric|min:0',
            'interest_rate' => 'numeric|min:0|max:100',
            'status' => 'in:Active,Dormant,Closed'
        ]);

        $savingAccount->update($request->all());
        return response()->json($savingAccount, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $savingAccount = SavingAccount::find($id);
        if (!$savingAccount) return response()->json(['message' => 'Saving account not found'], 404);

        $savingAccount->delete();
        return response()->json(['message' => 'Saving account deleted'], 200);
    }
}