<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralLedger;
use Illuminate\Validation\Rule;

class GeneralLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $generalLedgers = GeneralLedger::latest()->paginate(5);
        // return response()->json($generalLedgers);
        return view('master.general-ledger.list',compact('generalLedgers'));
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
        // return $request->all();   
        $validated = $request->validate([
            // 'parent_ledger_id' => 'nullable|exists:general_ledgers,id',
            'ledger_no' => 'required|unique:general_ledgers|max:50',
            'name' => 'required|max:100',
            'balance'=> 'required',
            'balance_type' => 'required|in:Credit,Debit',
            'open_balance'=>'required',
            'open_balance_type' => 'required|in:Credit,Debit',
            'min_balance' => 'required',
            // 'min_balance_type' => 'nullable|in:Credit,Debit',
            'interest_rate' => 'required',
            'open_date' => 'required|date',
            'gl_type' => 'required|in:Society,Store',
            'penal_rate' => 'nullable',
            'cd_ratio' => 'nullable',
            'add_interest_to_balance' => 'nullable',
            'item_of' => 'required',
            'group' => 'required',
            'subsidiary' => 'required',
            'send_sms' => 'required',
            'interest_type' => 'required|max:50',
            'type' => 'nullable',
            'demand' => 'nullable',
        ]);

        $generalLedger = GeneralLedger::create($validated);
        return redirect()->back()->with('success',  'General Ledger added successfully', 'generalLedger');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $generalLedger = GeneralLedger::with('schedule')->findOrFail($id);
        return response()->json($generalLedger);
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
        $generalLedger = GeneralLedger::findOrFail($id);
     
        $validated = $request->validate([
            // 'parent_ledger_id' =>'nullable|exists:general_ledgers,id',
            'ledger_no' => [
                'required',
                'max:50',
                Rule::unique('general_ledgers', 'ledger_no')->ignore($id),
            ],
            'name' => 'required|max:100',
            'balance'=> 'required',
            'balance_type' => 'required|in:Credit,Debit',
            'open_balance'=>'required',
            'open_balance_type' => 'required|in:Credit,Debit',
            'min_balance' => 'required',
            // 'min_balance_type' => 'nullable|in:Credit,Debit',
            'interest_rate' => 'required',
            'open_date' => 'required|date',
            'gl_type' => 'required|in:Society,Store',
            'penal_rate' => 'nullable',
            'cd_ratio' => 'nullable',
            'add_interest_to_balance' => 'nullable',
            'item_of' => 'required',
            'group' => 'required',
            'subsidiary' => 'required',
            'send_sms' => 'required',
            'interest_type' => 'required|max:50',
            'type' => 'nullable',
            'demand' => 'nullable',
        ]);

        $generalLedger->update($validated);
        return redirect()->back()->with('success',  'General Ledger updated successfully', 'generalLedger');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $id;
        $generalLedger = GeneralLedger::findOrFail($id);
        $generalLedger->delete();
        return redirect()->back()->with('success', 'General Ledger deleted successfully');
    }
}